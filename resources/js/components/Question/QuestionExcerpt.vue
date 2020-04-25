<template>
    <div class="media post">
        <div class="d-flex flex-column counters">
                <div class="votes">
                    <strong>{{question.votes_count}} {{str_plural('vote',question.votes_count)}} </strong>
                </div>        
            
            <div class="statusClasses">
                <strong>{{question.answers_count}}</strong> {{str_plural('answer',question.answers_count)}}
            </div>
            <div class="view">
                {{question.views + " "  + str_plural('view',question.views)}}
            </div>
        </div>
    
        <div class="media-body">
            <div class="d-flex align-items-center">
                <h3 class="mt-0">
                    <router-link 
                        :to="{name: 'questions.show', params: {slug: question.slug}}"
                        >
                    {{title}}
                    </router-link>
                </h3>
                <div class="ml-auto">
                    
                        <router-link 
                            :to="{name: 'questions.edit', params: {id: question.id}}"    
                            v-if="authorize('modify', question)"                        
                            class="btn btn-sm btn-outline-info">
                            edit
                        </router-link>
                    
                        <button
                            v-if="authorize('deleteQuestion', question)" 
                            class="btn btn-sm btn-outline-info"
                            @click="destroy()">
                            delete
                        </button>
                    
                </div>
            </div>
            <p class="lead">
                <a href="#">{{username}}</a>
                <small class="text-muted">{{created_date}}</small>
            </p>
            <div class="excerpt">{{excerpt}}</div>
        </div>
    </div>
</template>

<script>
import vote from '../Vote.vue';

export default {
    props: ['question','user'],
    components: {
        vote
    },
    data(){
        return {
            title: this.question.title,
            username: this.question.user.name,
            excerpt: this.question.excerpt,
            created_date: this.question.created_date
        }
    },
    methods: {
        str_plural(str, count){
            return str + ( count>1?'s': '');
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
                        //delete the data
                        axios.delete('/questions/' + this.question.id)
                            .then(({data})=>{
                                this.$toast.success(data.message,'Success',{timeout: 3000,position: 'bottomCenter'});
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
        statusClasses(){
            return ['status', this.question.status]
        }
    }

}
</script>