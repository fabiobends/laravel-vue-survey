<template>
    <div class="poll-container">
        <div v-for="(poll, i) in polls" :key="i">
            <div>{{ poll.poll_description }}</div>
            <div v-for="(option, index) in poll.options" :key="index">
                <input
                    type="radio"
                    :value="option.option_id"
                    :id="index"
                    v-model="picked[poll.id]"
                />
                {{ option.option_description }}
            </div>
            <div>
                <button @click="submitOption(poll.id)">
                    Confirm your option
                </button>
                <button @click="toggleStatistics(poll.id)">
                    Show statistics
                </button>
            </div>
            <div v-for="(vote, idx) in poll.votes" :key="idx">
                <p v-if="statusActive == poll.id">
                    {{ vote.option_id }}----{{ vote.qty }}
                </p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            polls: [],
            picked: [],
            statusActive: 0
        };
    },
    methods: {
        submitOption(id) {
            axios
                .post(`/api/poll/${id}/vote`, {
                    choice: this.picked[id]
                })
                .then(response => {
                    if (response.status == 200) {
                        console.log("Ok");
                        console.log(
                            `Post:  ${id}   Choice: ${this.picked[id]}`
                        );
                        this.picked = [];
                    }
                })
                .catch(e => console.log(e));
        },
        toggleStatistics(id) {
            if(this.statusActive === id){
              this.statusActive = 0;
            } else {
              this.statusActive = id;
            }
        }
    },
    mounted() {
        axios
            .get("/api/polls")
            .then(response => {
                this.polls = response.data;
                this.polls.map(poll => {
                    this.statusActive.push(false);
                });
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
</style>
