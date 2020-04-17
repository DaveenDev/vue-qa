<answer :answer="{{$answer}}" inline-template>
    
    <div class="post media">
        <vote :model="{{$answer}}" name="answer"></vote>

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
                        @can('update',$answer)
                        <a @click.prevent="edit" class="btn btn-sm btn-outline-info"> Edit</a>
                        @endcan
                        @can('delete',$answer)
                                    
                            <button class="btn btn-sm btn-outline-danger" @click="destroy">Delete</button>
                                    
                        @endcan
                    </div>
        
                    <div class="col-3">            </div>
                    <div class="col-3">            </div>
                    <div class="col-3">
                        
                        <!-- Show Each Answer Author -->
                        <user-info :model="{{$answer}}" :user="{{$answer->user}}" label="Answered"></user-info>
        
                    </div>
                </div>
           </div>
          
        </div>
    </div>
</answer>