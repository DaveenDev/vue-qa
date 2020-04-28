<template>
    <div class="container" v-if="question.id">
        <show-question :question="question" :user="user"></show-question>
        <answers :question="question"></answers>
    </div>
</template>

<script>
import ShowQuestion from '../components/Question/ShowQuestion.vue'
import Answers from '../components/Answer/Answers.vue'
import gEventBus from '../eventbus';

export default {
    props: ['slug'],
    components: {
        ShowQuestion,
        Answers
    },
    data(){
        return {
            question: {},
            user:{}
        }
    },
    mounted(){
        this.fetchQuestion();
        gEventBus.$on('answers-count-changed',(count)=>{
            this.question.answers_count=count;
        });
   
    },
    methods:{
        fetchQuestion(){
            axios.get(`/questions/${this.slug}`)
                .then(({data})=>{
                    this.question=data.data;
                    this.user=this.question.user;
                }).catch(error=>console.log(error));
        }
    }
}
</script>