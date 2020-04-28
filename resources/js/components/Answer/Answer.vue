<template>
    <div class="post media">
        <vote :model="answer" name="answer"></vote>

        <div class="media-body">
            <form v-if="editing" @submit.prevent="update">
                <div class="form-group" >
                    <textarea rows="10" v-model="body" class="form-control" required></textarea>
                </div>
                <button class="btn btn-primary" :disabled="isInvalid">Update</button>
                <button @click="cancel" type="button" class="btn btn-outline-secondary">Cancel</button>
            </form>
           <div v-else>
                <div v-html="bodyHtml"></div>
                <div class="row">
                    <div class="col-3">
                        
                        <a  v-if="authorize('modify',answer)"
                            @click.prevent="edit" class="btn btn-sm btn-outline-info"> Edit</a>
                                    
                        <button v-if="authorize('modify',answer)"
                            class="btn btn-sm btn-outline-danger" @click="destroy">Delete</button>           
                        
                    </div>
        
                    <div class="col-3">            </div>
                    <div class="col-3">            </div>
                    <div class="col-3">
                        
                        <!-- Show Each Answer Author -->
                        <user-info :model="answer" :user="answer.user" label="Answered"></user-info>
        
                    </div>
                </div>
           </div>
          
        </div>
    </div>
</template>

<script>

import functions from '../../mixins/functions.js';

export default {

    props: ['answer'],
    mixins: [functions],
    data(){
        return {
            body: this.answer.body,
            bodyHtml: this.answer.body_html,
            id: this.answer.id,
            questionID: this.answer.question_id,
            beforeEditCache: null,
            userdeleted: false
            //editing var is inside mixins
        }
    },
    methods: {
        setEditCache(){ //send to mixins
            this.beforeEditCache=this.body;
        },
        restoreFromCache(){ //send to mixins
            this.body=this.beforeEditCache;
            
        },
        payload(){ //send to mixins
            return {
                body:this.body
            }
        },     
        delete(){ //send to mixins
        
           axios.delete(this.endpoint)
                 .then(res=>{    
                    this.$toast.success(res.data.message,"Success",{timeout:2000,position:'bottomCenter'});         
                    this.$emit('deleted');
                   
                    
           });

        }
    },
    computed: {
        isInvalid(){
            return this.body.length < 10;
        },
        endpoint(){
            return `/questions/${this.questionID}/answers/${this.id}`;
        }
    }
    
}
</script>