<template>
    <tr :class="{ 'is-editing': showForm }">
        <td class="w-14 text-center" v-show="! showForm">
            <i class="fas fa-fw text-xl" :class="[ iconClass ]"></i>
        </td>

        <td v-show="! showForm">
            <a :href="teamUrl" v-text="team.name"></a>
        </td>

        <td v-text="team.sport" v-show="! showForm"></td>

        <td class="pr-4 text-right" v-if="auth" v-show="! showForm">
            <button class="button" @click="toggleForm">Edit</button>
        </td>

        <td colspan="4" v-show="showForm">
            <div class="flex">
                <input class="input" type="text" placeholder="Team name" v-model="team.name">

                <select class="input" v-model="team.sport">
                    <option value="">Choose sport...</option>
                    <option value="Baseball">Baseball</option>
                    <option value="Basketball">Basketball</option>
                    <option value="Football">Football</option>
                    <option value="Kan Jam">Kan Jam</option>
                    <option value="Soccer">Soccer</option>
                </select>

                <button class="button ml-2" @click="updateTeam">
                    Update
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
            team: {
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

            icon() {
                return collect({
                    Baseball:   'baseball-ball',
                    Basketball: 'basketball-ball',
                    Football:   'football-ball',
                    Soccer:     'futbol',
                }).get(this.team.sport, 'jedi');
            },

            iconClass() {
                return `fa-${this.icon}`;
            },

            teamUrl() {
                return route('teams.show', this.team.slug);
            }
        },

        methods: {
            toggleForm() {
                this.showForm = ! this.showForm;
            },

            updateTeam() {
                let payload = {
                    name:  this.team.name,
                    sport: this.team.sport
                };

                axios.put(route('api.teams.update', this.team.slug), payload)
                    .then(() => this.toggleForm());
            }
        }
    }
</script>
