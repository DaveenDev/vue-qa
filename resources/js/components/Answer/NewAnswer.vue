<template>
        <div v-if="!editMode" class="col-md-12 mt-3" >
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h3>Your Answer</h3>
                    </div>
                    <hr>
                       <form @submit.prevent="postAnswer">
                       <div class="form-group">
                           <textarea class="form-control" rows=7 name="body" required v-model="body"></textarea>
                       </div>
                       <div class="form-group">
                           <button class="btn btn-lg btn-outline-primary"
                                    :disabled="isInvalid" type="submit">Submit</button>
                       </div>
                   </form>
                </div>
            </div>
        </div>
 
</template>

<script>
import aEventBus from './answer-events';

export default{
    props: ['questionID'],
    data(){
        return {
            body: '',
            editing: false
        }
    },
    created(){  
        EventBus.$on('editMode', editing =>{
            this.editing=editing;
        });
    },
    computed: {
        isInvalid(){
            return !this.signedIn || this.body.length<10;
        },
        editMode(){
             return this.editing;
        }
    },
    methods:{
        postAnswer(){
            axios.post(`/questions/${this.questionID}/answers`,{body: this.body})
                 .then(({data})=>{
                     aEventBus.$emit('postedAnswer',data.answer);   
                     this.$toast.success(data.message,"Success",{timeout: 3000, position: 'bottomCenter'});
                     this.body='';
                                       
                });
            
        }
    }
}

</script>