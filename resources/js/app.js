require("./bootstrap");

import Vue from "vue";
import App from "./vue/App.vue";
import PollCreator from "./vue/components/PollCreator.vue";
import Polls from "./vue/components/Polls.vue";

new Vue({
    el: "#app",
    components: { App }
});

new Vue({
  el: "#create",
  components: { PollCreator }
});

new Vue({
  el: "#polls",
  components: { Polls }
});
