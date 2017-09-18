<template>
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <draggable class="list-group"
                v-model="qas"
                :options="{handle:'.handle'}"
                @end="onEnd"
                v-if="qas.length > 0">
                <div v-for="(qa, index) in qas" class="card qa">
                    <div class="card-header">
                        <div v-if="qa.edit">
                            <input type="text" class="form-control" v-model="qa.question" :value="qa.question">
                            <!-- TODO icone handle, with hand on cursor hover -->
                            <i class="handle">x</i>
                        </div>
                        <div v-else>
                            <strong>{{qa.question}}</strong>
                            <i class="handle">x</i>
                        </div>
                    </div>
                    <div class="card-block">
                        <div v-if="qas[index].edit">
                            <textarea class="form-control" v-model="qa.answer">{{qa.answer}}</textarea>
                            <button class="btn btn-primary" v-on:click="updateQa(qa)">update</button>
                            <button class="btn btn-primary" v-on:click="cancelQa(qa)">cancel</button>
                        </div>
                        <div v-else>
                            <cite class="card-blockquote">{{qa.answer}}</cite>
                            <button class="btn btn-primary" v-on:click="switchEdit(qa)">edit</button>
                        </div>
                    </div>
                    <div class="card-footer text-muted">
                        X days ago - XX likes
                    </div>
                </div>
            </draggable>
            <div class="list-group" v-if="qas.length < 0">
                There is nothing nothing
            </div>
        </div>
    </div>
</template>

<script>
    import draggable from 'vuedraggable'
    export default {
	components: {
            draggable,
        },
        mounted() {
            console.log('Component mounted.')
        },
        created() {
            // const url = urljoin(window.location.pathname, "/qas/")
            const url = window.location.pathname + "/qas/"
            this.reloadModel()
	},
        data() {
            return {
		qas: [],
                errors: [],
                options: {
                    handle: '.handle',
                }
            }
        },
        methods: {
            cancelQa(qa) {
                this.refreshQa(qa)
                this.switchEdit(qa)
            },
            reloadModel() {
                axios.get(window.location.pathname + "/qas/").then(response => {
                    this.qas = response.data
                    this.qas = this.qas.map((x) => {
                        x.edit = false
                        return x
                    })
                }).catch(e => {
                    this.errors.push(e)
                })
            },
            refreshQa(qa) {
                axios.get(window.location.pathname + "/qas/" + qa.id)
                .then((response) => {
                    qa.answer = response.data.answer
                    qa.question = response.data.question
                    console.log(response)
                })
                // In case of error, reload the old model
                .catch((error) => {
                    this.reloadModel()
                    console.log(error)
                })

            },
            updateQa(qa) {
                axios.post(window.location.pathname + "/qas/" + qa.id + "/update", {
                    answer: qa.answer,
                    question: qa.question,
                })
                .then((response) => { console.log(response) })
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
            onEnd(event) {
                const filtered = this.qas.map(x => x.id)
                axios.post(window.location.pathname + "/qas/reorder", {ids: filtered})
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
                axios.post(window.location.pathname + "/qas/" + qasId + "/up")
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
                axios.post(window.location.pathname + "/qas/" + qasId + "/down")
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
