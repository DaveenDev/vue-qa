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

import EventBus from './answer-events';

export default {

    props: ['answer'],
    data(){
        return {
            editing: false,
            body: this.answer.body,
            bodyHtml: this.answer.body_html,
            id: this.answer.id,
            questionID: this.answer.question_id,
            beforeEditCache: null,
            userdeleted: false
            
        }
    },
    methods: {
        edit(){
            this.beforeEditCache=this.body;
            this.editing=true;
            EventBus.$emit('editMode',this.editing);
        },
        cancel(){
            this.body=this.beforeEditCache;
            this.editing=false;
            EventBus.$emit('editMode',this.editing);
        },
        update(){
            
            axios.patch(this.endpoint,{
                body:this.body
            }).then(res=>{
                //console.log(res);
                this.editing=false;
                this.bodyHtml=res.data.body_html;
                this.$toast.success(res.data.message,'Success',{timeout: 3000});
                EventBus.$emit('editMode',this.editing);
            })
            .catch(err=>{
                this.$toast.error(err.response.data.message,'Error',{timeout: 3000});
            });
        },
        destroy(){
                      
            this.$toast.question('Are you sure about that?','Confirm',{
                timeout: 20000,
                close: false,
                overlay: true,
                displayMode: 'once',
                id: 'question',
                zindex: 999,
                position: 'center',
                buttons: [
                    ['<button><b>YES</b></button>', (instance, toast) =>{
                       axios.delete(this.endpoint)
                            .then(res=>{                
                                this.$emit('deleted');
                            });
        
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
            
                    }, true],
                    ['<button>NO</button>', function (instance, toast) {
            
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
            
                    }],
                ]
             
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