<template>
    
        <div class="col-md-12 mt-3" v-cloak v-if="count>0">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h3>{{title}}</h3>
                    </div>
                    <hr>
                    <answer v-for ="answer in answers" :answer="answer" :key="answer.id"></answer>
                </div>
                
                
            </div>
        </div>
 

</template>

<script>
import Answer from './Answer.vue';
export default {
    props: ['answers','count'],
    components: { Answer },
    computed: {
        title(){
            return  this.count + " " + (this.count > 1? 'Answers' : 'Answer');
        }
    }
}
</script>