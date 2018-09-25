<template>
    <div class="w-full">
        <div class="flex justify-between items-center">
            <h1>
                <a :href="teamIndexUrl">
                    <i class="fas fa-chevron-left mr-2"></i>
                </a>

                {{ team.name }}
            </h1>

            <button class="button" @click="toggleForm" v-if="auth" :disabled="showForm">
                Create Player
            </button>
        </div>

        <div class="mt-8" v-if="showForm">
            <h3 class="text-purple-dark">
                Create New Player
            </h3>

            <div class="flex mt-2">
                <input class="input" type="text" placeholder="First name" v-model="newPlayer.first_name">

                <input class="input" type="text" placeholder="Last name" v-model="newPlayer.last_name">

                <select class="input" v-model="newPlayer.position">
                    <option value="">Choose position...</option>

                    <option v-for="(position, key) in positions" :value="position" v-text="position"></option>
                </select>

                <button class="button ml-2" @click="savePlayer">
                    Save
                </button>

                <button class="button is-secondary" @click="toggleForm">
                    Cancel
                </button>
            </div>
        </div>


        <table class="w-full">
            <tbody>
                <player-table-row v-for="(player, key) in team.players" :player="player" :key="key"></player-table-row>
            </tbody>
        </table>
    </div>
</template>

<script>
    import PlayerTableRow from './PlayerTableRow';

    export default {
        props: {
            teamSlug: {
                type:     String,
                required: true
            }
        },

        components: {
            PlayerTableRow
        },

        data() {
            return {
                newPlayer: {
                    first_name: '',
                    last_name:  '',
                    position:   '',
                    team_id:    null,
                },
                showForm:  false,
                team:      {}
            }
        },

        created() {
            this.getTeam();
        },

        computed: {
            auth() {
                return window.auth;
            },

            teamIndexUrl() {
                return route('teams.index');
            },

            positions() {
                return collect(window.positions)
                    .get(this.team.sport);
            }
        },

        methods: {
            getTeam() {
                axios.get(route('api.teams.show', this.teamSlug))
                    .then(({data}) => {
                        this.team              = data;
                        this.newPlayer.team_id = data.id;
                    });
            },

            resetTeam() {
                this.newPlayer.first_name = '';
                this.newPlayer.last_name  = '';
                this.newPlayer.position   = '';
            },

            savePlayer() {
                axios.post(route('api.players.store'), this.newPlayer)
                    .then(() => {
                        this.getTeam();
                        this.toggleForm();
                        this.resetTeam();
                    });
            },

            toggleForm() {
                this.showForm = ! this.showForm;
            }
        }
    }
</script>
