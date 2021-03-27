<template>
    <div class="poll-container">
        <h1>Poll available</h1>
        <div v-for="(poll, i) in polls" :key="i" class="options-wrapper">
            <button @click="choosePoll(poll.id)">
                <div>{{ poll.id }}</div>
            </button>
            <div v-if="poll.id === selected" class="content-wrapper">
                <form
                    action=""
                    @submit.prevent="submitChoice(poll.id)"
                    method="post"
                    v-if="!isVoted[poll.id]"
                >
                    <p class="description">{{ poll.poll_description }}</p>
                    <div v-for="(option, index) in poll.options" :key="index">
                        <div class="option">
                            <input
                                type="radio"
                                :value="option.option_id"
                                name="choice"
                                id="choice"
                                v-model="choice"
                            />
                            <p>{{ option.option_description }}</p>
                        </div>
                    </div>
                    <button tupe="submit">Confirm answer</button>
                </form>
                <button
                    v-show="isVoted[poll.id]"
                    @click="showStatistics(poll.id)"
                >
                    See statistics
                </button>
                <div v-if="status === poll.id" class="statistics">
                    <p>Views: {{ statistics.views }}</p>
                    <div v-for="stat in statistics.votes" :key="stat.option_id">
                        <p>{{ stat.option_id }}---{{ stat.qty }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            polls: [],
            choice: 0,
            selected: 0,
            poll: {},
            isVoted: [],
            status: 0,
            statistics: []
        };
    },
    methods: {
        choosePoll(id) {
            if (this.selected === id) {
                this.selected = 0;
            } else {
                this.selected = id;
            }
            axios
                .get(`/api/poll/${id}`)
                .then(response => console.log(`Poll selected: ${id}`))
                .catch(e => console.log(e));
        },
        submitChoice(id) {
            if (this.choice !== 0) {
                axios
                    .post(`/api/poll/${id}/vote`, {
                        choice: this.choice
                    })
                    .then(response => {
                        console.log("Vote submitted");
                        this.choice = 0;
                        this.isVoted[id] = true;
                        this.status = 0;
                    })
                    .catch(error => console.log(error));
            }
        },
        showStatistics(id) {
            if (this.status === id) {
                this.status = 0;
            } else {
                axios
                    .get(`/api/poll/${id}/stats`)
                    .then(response => {
                        this.status = id;
                        this.statistics = response.data;
                        console.log("statistics");
                    })
                    .catch(error => console.log(error));
            }
        }
    },
    mounted() {
        axios
            .get("/api/polls")
            .then(response => {
                this.polls = response.data;
                // this.polls.map(poll => {
                //     this.status.push(false);
                // });
            })
            .catch(e => console.log(e));
    }
};
</script>

<style>
.poll-container {
    display: grid;
    place-items: center;
    width: 50vw;
    background: #e5e5e5;
    margin: 0 auto;
    padding: 2rem;
}

.option {
    display: flex;
    margin: 0.5rem;
}

.option input {
    margin-right: 0.5rem;
}

.options-wrapper {
    width: 80%;
    display: flex;
    flex-direction: column;
    align-items: center;
    margin: 1rem;
}

.options-wrapper form {
    padding: 1rem;
    margin-top: 0.5rem;
    background: #f0f0f0;
    border-radius: 1rem;
    display: flex;
    flex-direction: column;
}

.options-wrapper form > p {
    align-self: center;
    padding: 1rem;
}

.options-wrapper form button {
    margin-top: 1rem;
}

.statistics {
    padding: 1rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.statistics > p {
    padding: 0.5rem;
    align-self: center;
}

.content-wrapper {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 1rem;
}
</style>
