<template>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h2>Edit Question</h2>
                        <div class="ml-auto">
                            <router-link :to="{name: 'questions'}" class="btn btn-outline-secondary">Back</router-link>
                        </div>
                    </div>
                    

                </div>

                <div class="card-body">
                    <question-form @submitted="update" :editMode="true"></question-form>
                </div>
            </div>
        </div>
    </div>
</div>

</template>
<script>
import QuestionForm from '../components/Question/QuestionForm.vue';
import EventBus from '../eventbus';

export default {
    components: {
        QuestionForm
    },
    methods: {
        update(data){
            axios.put('/questions/' + this.$route.params.id, data)
                .then(res=>{
                    
                    this.$toast.success(res.data.message,'Success',{timeout:3000, position: 'bottomCenter'});
                    this.$router.push({name: 'questions'});
                    EventBus.$emit('updated',res.data.body_html);
                    //console.log(res.data);
                }).catch(({response})=>{
                    EventBus.$emit('error',response.data.errors);
                    this.$toast.warning(response.data.message,'Warning',{timeout:3000, position: 'bottomCenter'});
                    //console.log(response.data.errors);
                })
        }
    
    }    
}
</script>

