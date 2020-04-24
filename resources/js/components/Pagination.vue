<template>
    <div class="row align-items-center">
        <div class="col">
            <button class="btn btn-outline-secondary" :disabled="isFirst" @click="prev()">Newer</button>
        </div>
        <!-- 1st column -->
        <div class="col">
            {{pagesInfo}}
        </div>
        <!-- 2nd column -->
        <div class="col">
            <button class="btn btn-outline-secondary" :disabled="isLast" @click="next()" >Older</button>
        </div>
        <!-- 3rd column -->
    </div>
</template>

<script>
export default {
    props: ['meta','links'],
    computed: {
        pagesInfo(){
            return `Page ${this.meta.current_page} of ${this.meta.last_page}`;
        },
        isFirst(){
            return this.meta.current_page===1;
        },
        isLast(){
            return this.meta.current_page===this.meta.last_page;
        }
        
    },
    methods:{
        switchPage(){
            this.$router.push({
                name: 'questions',
                query: {
                    page: this.meta.current_page
                }
            });
        },
        prev(){
            if(!this.isFirst){
                this.meta.current_page--;
            }
            this.switchPage();
        },
        next(){
            if(!this.isLast){
                this.meta.current_page++;
            }
            this.switchPage();
        }
    }
   
}
</script>