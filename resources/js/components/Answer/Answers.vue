<template>
    
        <div class="col-md-12 mt-3" v-cloak v-if="count>0">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3>{{title}} </h3> 
                            </div>
                            <hr>
                            <spinner v-if="loading"></spinner>
                            <answer v-else 
                                v-for="(answer,index) in answers" :key="answer.id"
                                :answer="answer"
                                @deleted="remove(index)">
                            </answer>

                            <div class="text-center mt-3 " v-if="theNextUrl">
                                <button 
                                    @click.prevent="fetch(theNextUrl)"
                                    class="btn btn-outline-secondary">More...</button>        
                            </div>
                        </div>
                    
                    </div>
                    <new-answer :questionID="question.id" ></new-answer>
    </div>
    
    
</template>

<script>
import Answer from './Answer.vue';
import NewAnswer from './NewAnswer.vue';
import aEventBus from './answer-events';
import gEventBus from '../../eventbus';

export default {
    props: ['question'],
    components: { Answer ,NewAnswer},
    data(){
        return{
            questionID: this.question.id,
            count: this.question.answers_count,
            answers: [],
            nextUrl: null,
            excludeAnswers: [],
            loading: false
        }
    },
    mounted(){
        this.fetch(`/questions/${this.questionID}/answers`);

        aEventBus.$on('postedAnswer', answer=>{
            this.newAnswerAdded(answer);
        });
        
    },
    methods:{
        fetch(endpoint){
            this.loading=true;
            axios.get(endpoint)
                .then(res=>{
                    this.answers.push(...res.data.data); //... means merging data array with data, data3.push(...data1)
                    this.nextUrl=res.data.links.next;
                    //console.log(this.answers);
                    this.loading=false;
                }).catch(err=>{
                    this.loading=false;
                });
        },  
        
        remove(index){
            this.answers.splice(index,1); //remove the deleted index
            this.count--;
            
            gEventBus.$emit('answers-count-changed',this.count);
            
        },
        newAnswerAdded(answer){
            
            this.answers.push(answer);
            this.excludeAnswers.push(answer);
            this.count++;
             
                gEventBus.$emit('answers-count-changed', this.count);
            
        }
    },
    computed: {
        title(){
            return  this.count + " " + (this.count > 1? 'Answers' : 'Answer');
        },
        theNextUrl(){
            if(this.nextUrl && this.excludeAnswers.length){
                return this.nextUrl + this.excludeAnswers.map(a=>'&excludes[]=' + a.id).join('');
            }
            return this.nextUrl;
        }
    }
    
}
</script>