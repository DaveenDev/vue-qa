<template>
<div>
        <a v-if="canAccept" title="Mark this as Best Answer"  
            :class="classes" 
            @click.prevent="create">
            <i class="fa fa-check fa-2x"></i>
        </a>

        <a v-if="accepted" title="The question author has marked this as best answer"
            :class="classes">
            <i class="fa fa-check fa-2x"></i>
        </a>

</div>
</template>

<script>
import EventBus from '../event-bus';

export default {    
    props: ['answer'],
    data(){
            return {
                isBest: this.answer.is_best,
                id: this.answer.id
            }
    },
     computed: {
            canAccept(){
                //console.log('can accept ' + this.authorize('accept',this.answer));
                //!this.authorize('modify',this.answer);  calls the policy validation if the answer is owned by the questioner
                return this.authorize('accept',this.answer) && !this.authorize('modify',this.answer); 

            },
            accepted(){
                return !this.canAccept && this.isBest;
            },
            classes(){
                return [
                    'mt-2', 
                    this.isBest? 'vote-accepted' : ''
                ];
            }
        },
    created() {
            EventBus.$on('accepted',id=>{
                this.isBest=(id===this.id);
            })
    },
    methods: {
            create(){
                axios.post(`/answers/${this.id}/accept`)
                .then(res=>{
                    this.$toast.success(res.data.message,"Succes",{timeout: 3000,position: 'bottomCenter'});
                    this.isBest=true;   
                    EventBus.$emit('accepted',this.id);
                })
            }
     }
    
}
</script>