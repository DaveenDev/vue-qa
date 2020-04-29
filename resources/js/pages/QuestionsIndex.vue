<template>
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card" >
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h2>All Questions</h2>
                        <div class="ml-auto">
                        <router-link :to="{name: 'questions.create'}" class="btn btn-outline-secondary">Ask Question</router-link>
                        </div>
                    </div>
                    

                </div>

                <div class="card-body">
                    <spinner v-if="$root.loading" :small="false" ></spinner>
                    <div v-else-if="questions.length">
                        <question-excerpt 
                            v-for="(question,index) in questions" :key="question.id" 
                            :question="question" 
                            :user="question.user"
                            @deleted="remove(index)"
                        ></question-excerpt>
                    </div>
                    <div v-else>
                        <strong>There are no questions being raised.</strong>
                    </div>
                        
                    
                </div>
                <!-- pagination -->
                <div class="card-footer">
                        <pagination  :meta="meta" :links="links"></pagination>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import QuestionExcerpt from '../components/Question/QuestionExcerpt.vue';
import Pagination from '../components/Pagination.vue'

export default {
    components:{
        QuestionExcerpt, Pagination
    },
    data(){
        return {
            questions: [],
            meta: {},
            links: {}
            
        }
    },
    mounted(){
        
        this.fetchQuestions();
        
    },
    methods:{
        fetchQuestions(){
            axios.get('/questions',{params: this.$route.query})
                .then(({data})=>{
                    this.questions=data.data
                    this.meta=data.meta;
                    this.links=data.links;
                    
                });
        },
        remove(index){
            this.questions.splice(index,1);
            this.count--;
        }
    },
     watch:{
        "$route": 'fetchQuestions'
    }

}
</script>