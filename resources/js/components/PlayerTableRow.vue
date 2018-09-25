<template>
    <tr :class="{ 'is-editing': showForm }">
        <td class="pl-4" v-show="! showForm" v-text="name"></td>

        <td v-text="player.position" v-show="! showForm"></td>

        <td class="pr-4 text-right" v-if="auth" v-show="! showForm">
            <button class="button" @click="toggleForm">Edit</button>
        </td>

        <td colspan="3" v-show="showForm">
            <div class="flex">
                <input class="input" type="text" placeholder="First name" v-model="player.firstName">

                <input class="input" type="text" placeholder="Last name" v-model="player.lastName">

                <select class="input" v-model="player.position">
                    <option value="">Choose position...</option>

                    <option v-for="(position, key) in positions" :value="position" v-text="position"></option>
                </select>

                <button class="button ml-2" @click="updatePlayer">
                    Save
                </button>

                <button class="button is-secondary" @click="toggleForm">
                    Cancel
                </button>
            </div>
        </td>
    </tr>
</template>

<script>
    export default {
        props: {
            player: {
                type:     Object,
                required: true,
            }
        },

        data() {
            return {
                showForm: false
            }
        },

        computed: {
            auth() {
                return window.auth;
            },

            name() {
                return `${this.player.firstName} ${this.player.lastName}`;
            },

            positions() {
                return collect(window.positions)
                    .get(this.player.sport);
            }
        },

        methods: {
            toggleForm() {
                this.showForm = ! this.showForm;
            },

            updatePlayer() {
                let payload = {
                    first_name: this.player.firstName,
                    last_name:  this.player.lastName,
                    position:   this.player.position,
                };

                axios.put(route('api.players.update', this.player.id), payload)
                    .then(() => this.toggleForm());
            }
        }
    }
</script>
