<template>
    <div class="row">
        <div class="col-12">
            <form @submit.prevent="validateBeforeSubmit">
                <div class="row">
                    <div :class="{
			'col-lg-4': true,
			'offset-lg-2': true,
			'col-md-6': true,
			'from-group': true,
			'has-danger': errors.has('question'),
		    }">
                        <label for="question"><b>Question</b></label>
                        <textarea
			    v-validate="'required'"
			    v-model="question"
			    type="text"
			    :class="{'form-control': true, 'form-control-danger': errors.has('question')}"
			    name="question"
                            aria-describedby="question"
			    placeholder="Write the question"
			></textarea>
			<div v-show="errors.has('question')" class="form-control-feedback">{{ errors.first('question')}}</div>
                    </div>
                    <div :class="{
			'col-lg-4': true,
			'col-md-6': true,
			'from-group': true,
			'has-danger': errors.has('answer'),
		    }">
                        <label for="answer"><b>Answer</b></label>
                        <textarea
			    v-validate="'required'"
			    v-model="answer"
			    type="text"
			    :class="{'form-control': true, 'form-control-danger': errors.has('answer')}"
			    name="answer"
                            aria-describedby="answer"
			    placeholder="Write the answer"
			></textarea>
			<div v-show="errors.has('answer')" class="form-control-feedback">{{ errors.first('answer')}}</div>
                    </div>
                </div>
                <div class="row">
                    <div :class="{
			'col': true,
			'text-center': true,
			'form-group': true,
			'has-danger': recaptchaError,
		    }">
                        <br v-show="!is_admin"/>
                        <div v-show="!is_admin" class="g-recaptcha" data-sitekey="6LfzYC4UAAAAADARTXE5OdyOLsm6XiDhgersZzfz"></div>
			<div v-show="recaptchaError" class="form-control-feedback"><i class="fa fa-times fa-1x"></i>&nbsp;&nbsp;Recaptcha is missing.</div>
                        <br/>
                        <button type="submit" class="btn btn-primary">Add Question</button>
                        <br/>
                        <br/>
                    </div>
                </div>
            </form>
	</div>
    </div>
</template>

<script>
    import autosize from "autosize"

    export default {
        props: ["is_admin", "faq_id", "admin_code"],
        mounted() {
            console.log('Component mounted.')
            autosize(document.querySelectorAll('textarea'))
        },
        created() {
            // TODO could use the recaptcha call back instead of an ugly interval
            if(this.is_admin) {
                this.recaptchaInterval = setInterval(() => {
                    if($("#g-recaptcha-response").val() !== "") {
                        this.recaptchaError = false
                    }
                }, 1000);
            }
	},
        data() {
            return {
		question: undefined,
		answer: undefined,
                recaptchaError: undefined,
                recaptchaInterval: undefined,
            }
        },
        methods: {
            validateBeforeSubmit() {
		this.$validator.validateAll().then((result) => {
                    const recaptchaResponse = $("#g-recaptcha-response").val() !== ""
		    if (result && (this.is_admin || recaptchaResponse)) {
                        if(this.is_admin) {
                            // TODO find a way to update the QAs without reloading the page
                            axios.post("/faq/" + this.faq_id + "/qa_create?admin_code=" + this.admin_code, {
                                answer: this.answer,
                                question: this.question,
                            })
                            .then((response) => {
                                console.log(response)
                                // not convinced to do this way
                                window.location = response.request.responseURL
                            })
                            // In case of error, reload the old model
                            .catch((error) => {
                                console.log(error)
                            })
                        } else {
                            axios.post("/faq/create", {
                                answer: this.answer,
                                question: this.question,
                                "g-recaptcha-response": $("#g-recaptcha-response").val(),
                            })
                            .then((response) => {
                                // not convinced to do this way. The flash messages are lost
                                window.location = response.request.responseURL
                            })
                            // In case of error, reload the old model
                            .catch((error) => {
                                console.log(error)
                            })
                        }
		    	console.log(result)
			return
		    }

                    // could only use the interval, but if doing so, directly at the start of the
                    // web page we would see the "missing captcha" error
                    if( !recaptchaResponse ) {
                        this.recaptchaError = true
                        return
                    }
		    console.log('There were errors in the vee validation part');
		});
	    },
        },
    }
</script>
