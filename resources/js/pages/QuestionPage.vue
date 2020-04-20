<template>
    <div>
        <show-question :question="question" :user="user"></show-question>
        <answers :question="question"></answers>
    </div>
</template>

<script>
import ShowQuestion from '../components/Question/ShowQuestion.vue'
import Answers from '../components/Answer/Answers.vue'
export default {
    props: ['question','user'],
    components: {
        ShowQuestion,
        Answers
    }
}
</script>