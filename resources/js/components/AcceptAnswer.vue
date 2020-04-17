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
export default {
    props: ['answer'],
    data(){
        return {
            isBest: this.answer.is_best,
            id: this.answer.id,
        }
    },
    computed: {
        canAccept(){
            //console.log('can accept ' + this.authorize('accept',this.answer));
            return this.authorize('accept',this.answer);

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
    methods: {
        create(){
            axios.post(`/answers/${this.id}/accept`)
            .then(res=>{
                this.$toast.success(res.data.message,"Succes",{timeout: 3000,position: 'bottomCenter'});
                this.isBest=true;
            })
        }
    }
}
</script>