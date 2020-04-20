<template>
      <div class="col-md-12">
            <div class="card">
                  <!-- Show edit mode of Question -->
                  
                <form class="card-body" v-if="editing" @submit.prevent="updateQuestion">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" :value="title" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="body">Body</label>
                        <textarea name="body" id="body" rows="10" class="form-control" v-model="body">
                            
                        </textarea>
                    </div>
                    <div class="form-group">
                        <button type="Submit" class="btn btn-primary btn-sm mt-1"
                                    @click.prevent="updateQuestion()"
                                    > Update</button>        
                                <button type="button" class="btn btn-secondary btn-sm mt-1" 
                                        @click.prevent="cancel()">Cancel</button>
                        
                    </div>

                </form>
                <!-- Show Index of Questions -->
                <div class="card-body" v-else>
                    <div class="card-title">
                        <div class="d-flex align-items-center">
                            <h2>{{title}}</h2>
                            <div class="ml-auto">
                                <a href="/questions" class="btn btn-outline-secondary">Back to All Questions</a>
                            </div>
                        </div>
                    </div>
               

                    <div class="media">
                    <!-- Show Each Question Vote Control -->
                    <vote :model="question" name="question"></vote>  
                    
                        <div class="media-body">
                                <div v-html="body"></div>
                                

                                <a v-if="authorize('modify',question)"
                                    class="btn btn-sm btn-outline-info"
                                    @click.prevent="edit()"
                                    > Edit</a>        
                                <button v-if="authorize('deleteQuestion',question)"
                                        type="button" class="btn btn-sm btn-outline-danger" 
                                        @click.prevent="delQuestion()">Delete</button>
                                
                            
                                <div class="row mb-3">
                                    <div class="col-4"></div>
                                    <div class="col-4"></div>
                                    <div class="col-4">

                                        <!-- Show Each Question Author -->
                                        <user-info :model="question" :user="user" label="Asked"></user-info>

                                    </div>
                                </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
</template>

<script>
export default {
    props: ['question','user'],
    data(){
        return {
            title: this.question.title,
            body: this.question.body,
            body_html: this.question.body_html,
            editing: false,
            beforeEditCache: {},
            id: this.question.id
        }
    },
    computed: {
        isInvalid(){
            return this.body.length<100 || this.title.length<10;
        },
        editquestion_url() {
            return `/questions/${this.id}`;
        }
    },
    methods: {
        edit(){
            this.editing=true;
            this.beforeEditCache={
                title: this.title,
                body: this.body,
            };

        },
        cancel(){
            this.editing=false,
            this.title=this.beforeEditCache.title,
            this.body=this.beforeEditCache.body
        },
        updateQuestion(){
            axios.put(this.editquestion_url,{
                title: this.title, 
                body:this.body
            }).catch(({response})=>{
                this.$toast.error(response.data.message,"Error",{timeout:3000,position:'bottomCenter'});
            }).then(({data})=>{
                this.bodyHtml=data.body_html;
                this.$toast.success(data.message,"Success",{timeout:3000,position:'bottomCenter'});
                this.editing=false;
            })
        },
        delQuestion(){
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
                       axios.delete(`/questions/${this.id}`)
                            .then(({data})=>{                
                                 this.$toast.success(data.message,"Success",{timeout:2000,position:'bottomCenter'});
                                
                                setTimeout(()=>{
                                    window.location.href="/questions";
                                },2000);
                                
                            });
        
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
            
                    }, true],
                    ['<button>NO</button>', function (instance, toast) {
            
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
            
                    }],
                ]
             
            });
        }
    }
}
</script>