<template>
    <div class="row">
        <div class="col-lg-8 offset-lg-2 col-sm-12">
            <draggable class="list-group"
                v-model="qas"
                :options="{handle:'.handle'}"
                @end="onEnd"
                v-if="qas.length > 0">
                <div v-for="qa in qas" class="card qa">
                    <div class="card-header">
                        <div v-if="qa.edit">
                            <input type="text" class="form-control" v-model="qa.question" :value="qa.question">
                        </div>
                        <div v-else>
                            <div class="row">
                                <div class="col-11">
                                    <strong>{{qa.question}}</strong>
                                </div>
                                <div v-if="is_admin" class="col-1 text-right">
                                    <i class="handle fa fa-arrows fa-1x text-right"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-block">
                        <div v-if="qa.edit">
                            <textarea class="form-control" v-model="qa.answer">{{qa.answer}}</textarea>
                        </div>
                        <div v-else>
                            <cite class="card-blockquote">{{qa.answer}}</cite>
                        </div>
                    </div>
                    <div class="card-footer text-muted">
                        <span v-if="qa.edit">
                            <div class="row">
                                <div class="col-md-7 vertical-center col-sm-6">
                                    X days ago
                                </div>

                                <div class="col-md-5 text-right col-sm-6">
                                    <button class="btn btn-outline-primary" v-on:click="updateQa(qa)" v-if="qa.edit">update</button>
                                    <button class="btn btn-outline-secondary" v-on:click="cancelQa(qa)" v-if="qa.edit">cancel</button>
                                    <button class="btn btn-outline-danger" data-toggle="modal" data-target="#deleteModal" v-if="qa.edit" v-on:click="confirmationDeleteQa = qa">
					<i class="fa fa-trash fa-1x"></i>
				    </button>
                                </div>
                            </div>
                        </span>
                        <span v-else>
                            <div class="row">
                                <div class="col-11">
                                    {{qa.since}} days ago
                                </div>

                                <div class="col-1 text-right" v-if="is_admin">
                                    <a v-if="!qa.edit" class="" v-on:click="switchEdit(qa)"><i class="fa fa-cog fa-1x"></i></a>
                                </div>
                            </div>
                        </span>
                    </div>
                </div>
            </draggable>
            <div class="list-group" v-if="qas.length < 0">
                There is nothing nothing
            </div>
        </div>
	<!-- Delete Modal -->
	<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	    <div class="modal-dialog" role="document">
		<div class="modal-content">
		    <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">Delete QA</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		    </div>
		    <div class="modal-body">
			You really want to delete the QA: <cite>{{confirmationDeleteQa.question}}</cite>
		    </div>
		    <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<button type="button" v-on:click="deleteQa(confirmationDeleteQa)" data-dismiss="modal" class="btn btn-danger">Delete</button>
		    </div>
		</div>
	    </div>
	</div>
    </div>
</template>

<script>
    import draggable from "vuedraggable"
    import moment from "moment"

    export default {
        props: ["is_admin", "faq_id"],
	components: {
            draggable,
        },
        mounted() {
            console.log('Component mounted.')
        },
        created() {
            // const admin_code = new URL(window.location.href).searchParams.get("admin_code");
            // const url = urljoin(window.location.pathname, "/qas/")
            // const url = window.location.pathname + "/qas/"
            this.reloadModel()
	},
        data() {
            return {
                confirmationDeleteQa: {question: "None", answer: "None"},
		qas: [],
                options: {
                    handle: '.handle',
                }
            }
        },
        methods: {
            getAdminCode() {
                return new URL(window.location.href).searchParams.get("admin_code")
            },
            cancelQa(qa) {
                this.refreshQa(qa)
                this.switchEdit(qa)
            },
            reloadModel() {
                axios.get("/faq/" + this.faq_id + "/qas").then(response => {
                    this.qas = response.data
                    this.qas = this.qas.map((x) => {
                        x.edit = false
                        x.since = moment.utc(x.created_at, "YYYY-MM-DD hh:mm:ss").fromNow()
                        return x
                    })
                    this.$forceUpdate()
                }).catch(e => {
                    console.log(e)
                })
            },
            refreshQa(qa) {
                axios.get(window.location.origin + "/qa/" + qa.id)
                .then((response) => {
                    qa.answer = response.data.answer
                    qa.question = response.data.question
                    // console.log(response)
                })
                // In case of error, reload the old model
                .catch((error) => {
                    this.reloadModel()
                    console.log(error)
                })

            },
            updateQa(qa) {
                axios.post("/qa/" + qa.id + "/update?admin_code=" + this.getAdminCode(), {
                    answer: qa.answer,
                    question: qa.question,
                })
                .then((response) => {
                    // console.log(response)
                })
                // In case of error, reload the old model
                .catch((error) => {
                    reloadQa(qa)
                    console.log(error)
                })

                this.switchEdit(qa)
            },
            switchEdit(qa) {
                const index = this.qas.findIndex(x => x.id === qa.id)
                this.qas[index].edit = !this.qas[index].edit
                this.$forceUpdate()
                return false
            },
            deleteQa(qa) {
                axios.post("/qa/" + qa.id + "/delete?admin_code=" + this.getAdminCode())
                .then((response) => {
		    console.log(response)
		    this.reloadModel()
		})
                // In case of error, reload the old model
                .catch((error) => { console.log(error) })

                this.switchEdit(qa)
            },
            onEnd(event) {
                const filtered = this.qas.map(x => x.id)
                axios.post(window.location.pathname + "/qas_reorder?admin_code=" + this.getAdminCode(), {ids: filtered})
                .then((response) => {
                    // maybe too heavy, could just invert
                    // console.log(response)
                })
                .catch((error) => {
                    console.log(error)
                })
            },
            // not used currently
            up(qasId) {
                // move up the qa
                axios.post("/qa/" + qasId + "/up?admin_code=" + this.getAdminCode())
                .then((response) => {
                    // maybe too heavy, could just invert
                    this.reloadModel()
                    console.log(response)
                    // TODO manage the flash errors (https://github.com/limonte/sweetalert2)
                })
                .catch((error) => {
                    console.log(error)
                })
            },
            down(qasId) {
                // move up the qa
                axios.post("/qa/" + qasId + "/down?admin_code=" + this.getAdminCode())
                .then((response) => {
                    // maybe too heavy, could just invert
                    this.reloadModel()
                    // TODO manage the flash errors (https://github.com/limonte/sweetalert2)
                })
                .catch((error) => {
                    console.log(error)
                })
            },
        },
    }
</script>
