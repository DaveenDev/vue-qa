<template>
      <div class="col-md-12">
            <div class="card">
               
                <!-- Show Index of Questions -->
                <div class="card-body" v-if="!editing">
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
                                <div v-html="body_html"></div>

                                <a v-if="authorize('modify',question)"
                                    class="btn btn-sm btn-outline-info"
                                    @click.prevent="edit()"
                                    > Edit</a>        
                                <button v-if="authorize('deleteQuestion',question)"
                                        type="button" class="btn btn-sm btn-outline-danger" 
                                        @click.prevent="destroy()">Delete</button>
                                
                            
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

                   <!-- Show edit mode Question -->
                <form class="card-body" v-if="editing" @submit.prevent="update()">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" :value="title" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="body">Body</label>
                        <m-editor :body="body"> 
                            <!-- tobe displayed on <slot></slot> on MEditor-->
                            <textarea name="body" id="body" rows="10" class="form-control" v-model="body"></textarea>
                        </m-editor>    
                        
                    </div>
                    <div class="form-group">
                        <button type="Submit" class="btn btn-primary btn-sm mt-1"> Update</button>        
                                <button type="button" class="btn btn-secondary btn-sm mt-1" 
                                        @click.prevent="cancel()">Cancel</button>
                        
                    </div>

                </form>
            </div>
        </div>
</template>

<script>

import functions from '../../mixins/functions';
import MEditor from '../../components/MEditor.vue';


export default {
    props: ['question','user'],
    mixins: [functions],
    components:{
        MEditor
    }, 
    data(){
        return {
            title: this.question.title,
            body: this.question.body,
            body_html:this.question.body_html,
            beforeEditCache: {},
            id: this.question.id
        }
    },
    computed: {
        isInvalid(){
            return this.body.length<100 || this.title.length<10;
        },
        endpoint() {
            return `/questions/${this.id}`;
        },
        
    },
    methods: {
        setEditCache(){ //send to mixins
            this.beforeEditCache=this.body;
           
        },
        restoreFromCache(){ //send to mixins
            this.body=this.beforeEditCache;
        },
        updatePayload(){ //send to mixins
            return {
                title: this.title,
                body: this.body,
            }
        },     
        delete(){ //send to mixins
                       axios.delete(`/questions/${this.id}`)
                            .then(({data})=>{                
                          
                                this.$toast.success(data.message,"Success",{timeout:1500,position:'bottomCenter'});
                                setTimeout(()=>{
                                    this.$router.push({name:'questions'});
                                },2000);
                                
                            });       
            
        }
    }
    
}
</script>