<template>
    <div class="container">
        <a href="/polls" class="polls">See polls</a>
        <a href="/create" class="create">Create a poll</a>
    </div>
</template>

<script>
export default {
    name: "App"
};
</script>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.container {
    display: grid;
    place-items: center;
}

body {
    background: #f9f9f9;
}

a {
    display: block;
    text-decoration: none;
    width: 20rem;
    padding: 2rem;
    text-align: center;
    color: white;
    margin: 2rem;
    border-radius: 1rem;
}

.polls {
    background: green;
}

.create {
    background: blue;
}
</style>
