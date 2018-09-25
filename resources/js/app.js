require('./bootstrap');

window.Vue = require('vue');

import TeamTable from './components/TeamTable';
import TeamsTable from './components/TeamsTable';

Vue.component('team-table', TeamTable);
Vue.component('teams-table', TeamsTable);

new Vue({
    el: '#app'
});
