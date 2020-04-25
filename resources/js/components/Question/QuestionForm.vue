<template>
<div>
    <form @submit.prevent="postQuestion">
                      <div class="form-group">
                        <label for="title">Title</label>
                            <input type="text" name="title" id="title"  :class="errorClass('title')" v-model="title">
                        <div v-if="errors['title'][0]" class="invalid-feedback">
                            <strong>{{errors['title'][0]}}</strong>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="body">Body</label>
                            <m-editor :body="body" name="question-body">
                                <textarea name="body" id="body" rows="10" :class="errorClass('body')" v-model="body">                            </textarea>
                                <div v-if="errors['body'][0]" class="invalid-feedback">
                                <strong>{{errors['body'][0]}}</strong>
                                </div>
                            </m-editor>
                        
                    </div>
                    <div class="form-group">
                        <button type="Submit" class="btn btn-outline-primary btn-lg" >{{buttonText}}</button>
                    </div>

                </form>
</div>
</template>


<script>
import EventBus from '../../eventbus';
import MEditor from '../MEditor.vue';

export default {
    props: {
        editMode: {
            type: Boolean,
            default: false
        }
    },
    components: {MEditor},
    data(){
        return {
            title: '',
            body : '',
            errors: {
                title: [],
                body: []
            }
        }
    },
    mounted(){
        EventBus.$on('error',errors=>{
            this.errors=errors
        });

        if (this.editMode){
            this.fetchQuestion();
        }
    },
    computed: {
        isInvalid(){
            return  this.title.length<8 && this.body.length<10;
        },
        buttonText(){
            return this.editMode ? 'Update Question' : 'Ask Question'
        }
    },
    methods:{
        errorClass(field){
            return [
                'form-control',  
                this.errors[field] && this.errors[field][0] ? 'is-invalid':''
            ];
        },
        postQuestion(){
            this.$emit('submitted',{
                title: this.title,
                body: this.body
            });
        },
        fetchQuestion(){ //get question to update on editmode
            axios.get(`/questions/${this.$route.params.id}`)
                .then(({data})=>{
                    this.title=data.title,
                    this.body=data.body
                }).catch(error => {
                    this.$toast.warning(error.data.message,'Warning',{timeout:3000, position: 'bottomCenter'});
                });
        }
    }
}
</script>