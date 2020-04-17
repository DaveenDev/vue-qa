<template>
   

<div class="d-flex flex-column vote-controls">
    <a :title="title('up')" 
        :class="classes" 
        @click.prevent="voteUp"
        >
        <i class="fa fa-caret-up fa-2x"></i>
    </a>
    
    <span class="votes-count">{{count}}</span>
    <a :title="title('down')" 
        :class="classes" 
        @click.prevent="voteDown"
        > 
        <i class="fa fa-caret-down fa-2x"></i>
    </a>
    
        <favorite v-if="name==='question'" :question="model"></favorite>
        <accept-answer v-else :answer="model"></accept-answer>
    
</div>
    
</template>


<script>
import Favorite from './Favorite.vue';
import AcceptAnswer from './AcceptAnswer.vue';

export default {
    props: ['name','model'],
    components:{
        Favorite,
        AcceptAnswer
    },
    data(){
        return {
            id: this.model.id,
            count: this.model.votes_count
        }
    },
    computed: {
        classes(){
            return this.signedIn ? '' : 'off';
        },
        endpoint(){
            return `/${this.name}s/${this.id}/vote`;
        }
    },
    methods: {
        title(voteType){
            let titles={
                up: `This is ${this.name} is useful`,
                down: `This is ${this.name} is not useful`
            };
            return titles[voteType];
        },
        voteUp(){
            this._vote(1);
        },
        voteDown(){
            this._vote(-1);
        },
        _vote(vote){
            if(!this.signedIn){
                this.$toast.warning(`Please login to vote the ${this.name}`,"Warning",{timeout: 3000,position: 'bottomCenter'});
                return;
            }
            axios.post(this.endpoint,{
                vote: vote
            }).then(res=>{
               this.$toast.success(res.data.message,"Success",{timeout: 3000,position: 'bottomCenter'});
               this.count=res.data.votesCount;
            });
            
        }


    }
}
</script>