<template>
    <div class="card ">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab"  role="tab" href="#write" aria-selected="true">Write</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab"  role="tab" href="#preview">Preview</a>
            </li>
            </ul>
        </div>
        <div class="card-body tab-content" >
            <div class="tab-pane active" id="write"> <slot></slot></div>
            <div class="tab-pane" id="preview" v-html="preview"></div>
        </div>
    </div>
</template>

<script>

import autosize from 'autosize';

import MardownIt from 'markdown-it';
const md=new MardownIt();


export default {
    props: ['body'],
    computed: {
        preview(){
            return md.render(this.body);
        }
    },
    watch: {
        body: function(){
            autosize(document.querySelector('textarea'));
        }
    }

}
</script>