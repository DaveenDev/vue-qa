
<template>

    <div class="container text-center jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-4">Page not found</h1>
            <p class="lead">Sorry, page you're looking does not exist.</p>
            <hr>
            <router-link :to="{name: 'home'}" class="btn btn-primary btn-lg">Back to home page</router-link>
        </div>
    </div>
</template>
