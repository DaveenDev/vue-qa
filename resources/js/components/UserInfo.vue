<template>
<div class="author">
    <span class="text-muted">{{postDate}}</span>
    <div class="media media-right mt-6">
    
        <a :href="user.url" class="pr-2">
            <img :src="user.avatar"> 
        </a>

        <div class="media-body">
            <a :href="user.url">
                {{user.name}}
            </a>
        </div>
    </div>
</div>
</template>

<script>
    export default{
        props: ['model','label','user'],
        computed: {
            postDate(){
                return this.label + " " + this.model.created_date
            }
        },
       
    }
</script>