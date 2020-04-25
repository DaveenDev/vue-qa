import EventBus from '../components/Answer/answer-events';

export default {
    data(){
        return {
           editing: false
        }
    },
    methods: {
        edit(){
            this.setEditCache();
            this.editing=true;
            EventBus.$emit('editMode',this.editing);
        },
        cancel(){
            this.restoreFromCache();
            this.editing=false;
            EventBus.$emit('editMode',this.editing);
        },
        setEditCache(){},
        restoreFromCache(){},
        update(){
            
            axios.patch(this.endpoint, this.payload()
            ).then(res=>{
                //console.log(res);
                this.editing=false;
                this.bodyHtml=res.data.body_html;
                this.$toast.success(res.data.message,'Success',{timeout: 3000,position: 'bottomCenter'});
                EventBus.$emit('editMode',this.editing);
            })
            .catch(err=>{
                //console.log(err);
                this.$toast.warning(err.response.data.message,'Warning',{timeout: 3000,position: 'bottomCenter'});
            });
        },
        payload(){}
    }
}