<template>
    <div class="poll-wrapper">
        <form @submit.prevent="submitPoll()" method="post" class="form-wrapper">
            <label for="description">Type a description</label>
            <input type="text" v-model="description" />
            <label for="option-1">First option</label>
            <input type="text" v-model="options[0]" />
            <label for="option-2">Second option</label>
            <input type="text" v-model="options[1]" />
            <label for="option-3">Third option</label>
            <input type="text" v-model="options[2]" />
            <button type="submit">
                Corfirm new poll
            </button>
            <button class="back" @click="goBack()">
                Go back
            </button>
        </form>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            description: "",
            options: ["", "", ""]
        };
    },
    methods: {
        submitPoll() {
            if (
                this.description !== "" &&
                this.options[0] !== "" &&
                this.options[1] !== "" &&
                this.options[2] !== ""
            ) {
                axios
                    .post("/api/poll", {
                        poll_description: this.description,
                        options: this.options
                    })
                    .then(response => {
                        (this.description = ""), (this.options = ["", "", ""]);
                        console.log("Poll submitted");
                    })
                    .catch(e => console.log(e));
            }
        },
        goBack() {
            window.history.back();
        }
    }
};
</script>

<style>
.poll-wrapper {
    display: flex;
    justify-content: center;
}

.form-wrapper {
    background: #ddd;
    display: flex;
    justify-content: center;
    flex-direction: column;
    width: 30rem;
    margin: 0 auto;
    padding: 2rem;
}
</style>
