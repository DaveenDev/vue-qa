<template>
    <div class="container" v-if="question.id">
        <question :question="question" :user="user"></question>
        <answers :question="question"></answers>
    </div>
</template>

<script>
import Question from '../components/Question/Question.vue'
import Answers from '../components/Answer/Answers.vue'
import gEventBus from '../eventbus';

export default {
    props: ['slug'],
    components: {
        Question,
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