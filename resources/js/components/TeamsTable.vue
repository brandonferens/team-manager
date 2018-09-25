<template>
    <div class="w-full">
        <div class="flex justify-between items-center">
            <h1>Teams</h1>

            <button class="button" @click="toggleForm" v-if="auth" :disabled="showForm">
                Create Team
            </button>
        </div>

        <div class="mt-8" v-if="showForm">
            <h3 class="text-purple-dark">
                Create New Team
            </h3>

            <div class="flex mt-2">
                <input class="input" type="text" placeholder="Team name" v-model="newTeam.name">

                <select class="input" v-model="newTeam.sport">
                    <option value="">Choose sport...</option>
                    <option value="Baseball">Baseball</option>
                    <option value="Basketball">Basketball</option>
                    <option value="Football">Football</option>
                    <option value="Kan Jam">Kan Jam</option>
                    <option value="Soccer">Soccer</option>
                </select>

                <button class="button ml-2" @click="saveTeam">
                    Save
                </button>

                <button class="button is-secondary" @click="toggleForm">
                    Cancel
                </button>
            </div>
        </div>


        <table class="w-full">
            <tbody>
            <team-table-row v-for="(team, key) in teams" :team="team" :key="key"></team-table-row>
            </tbody>
        </table>
    </div>
</template>

<script>
    import TeamTableRow from './TeamTableRow';

    export default {
        props: [],

        components: {
            TeamTableRow
        },

        data() {
            return {
                newTeam:  {
                    name:  '',
                    sport: ''
                },
                showForm: false,
                teams:    {}
            }
        },

        created() {
            this.getTeams();
        },

        computed: {
            auth() {
                return window.auth;
            }
        },

        methods: {
            getTeams() {
                axios.get(route('api.teams.index'))
                    .then(({data}) => {
                        this.teams = data;
                    });
            },

            resetForm() {
                this.newTeam = {
                    name:  '',
                    sport: ''
                };
            },

            saveTeam() {
                axios.post(route('api.teams.store'), this.newTeam)
                    .then(() => {
                        this.getTeams();
                        this.toggleForm();
                        this.resetForm();
                    });
            },

            toggleForm() {
                this.showForm = ! this.showForm;
            }
        }
    }
</script>
