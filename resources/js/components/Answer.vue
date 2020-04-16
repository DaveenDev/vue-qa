

<script>


export default {
    props: ['answer'],
    data(){
        return {
            editing: false,
            body: this.answer.body,
            bodyHtml: this.answer.body_html,
            id: this.answer.id,
            questionID: this.answer.question_id,
            beforeEditCache: null,
            userdeleted: false
            
        }
    },
    methods: {
        edit(){
            this.beforeEditCache=this.body;
            this.editing=true;
        },
        cancel(){
            this.body=this.beforeEditCache;
            this.editing=false;
        },
        update(){
            
            axios.patch(this.endpoint,{
                body:this.body
            }).then(res=>{
                console.log(res);
                this.editing=false;
                this.bodyHtml=res.data.body_html;
                this.$toast.success(res.data.message,'Success',{timeout: 3000});
            })
            .catch(err=>{
                this.$toast.error(err.response.data.message,'Error',{timeout: 3000});
            });
        },
        destroy(){
                      
            this.$toast.question('Are you sure about that?','Confirm',{
                timeout: 20000,
                close: false,
                overlay: true,
                displayMode: 'once',
                id: 'question',
                zindex: 999,
                position: 'center',
                buttons: [
                    ['<button><b>YES</b></button>', (instance, toast) =>{
                       axios.delete(this.endpoint)
                                            .then(res=>{
                                                $(this.$el).fadeOut(500, ()=>{
                                                    this.$toast.success(res.data.message,'Deleted',{position: 'bottomCenter'});
                                                })
                        });
        
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
            
                    }, true],
                    ['<button>NO</button>', function (instance, toast) {
            
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
            
                    }],
                ]
             
            });

        }
    },
    computed: {
        isInvalid(){
            return this.body.length < 10;
        },
        endpoint(){
            return `/questions/${this.questionID}/answers/${this.id}`;
        }
    }
    
}
</script>