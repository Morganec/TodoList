<template>
    <div class="container">
        <span class="task-list-title">Mes tâches</span>

        <div class="row todayTask">
            <div class="col">
                <div class="row"><span>Aujourd'hui</span></div>
                <span class="row" v-if="thisWeekTaskList.length === 0">Vous n'avez pas de tâche pour aujourd'Hui</span>
                <div v-else class="row">
                    <task-component v-for="task in todayTaskList" :key="task.id" :task="task"></task-component>
                </div>
            </div>
        </div>

        <div class="row thisWeekTask">
            <div class="col">
                <div class="row">
                    <span>Cette semaine</span></div>
            <span class="row" v-if="thisWeekTaskList.length === 0">Vous n'avez pas de tâche pour cette semaine</span>
            <div v-else class="row">
                <task-component v-for="task in thisWeekTaskList" :key="task.id" :task="task"></task-component>
            </div></div>
        </div>

        <div class="row thisMonth">
            <div class="col">
                <div class="row">
                    <span>Ce mois</span></div>
            <span class="row" v-if="thisMonthTaskList.length === 0">Vous n'avez pas de tâche pour ce mois</span>
            <div v-else class="row">
                <task-component v-for="task in thisMonthTaskList" :key="task.id" :task="task"></task-component>
            </div></div>
        </div>

        <div class="row dueLater">
            <div class="col">
                <div class="row">
                    <span>Plus tard</span></div>
            <span class="row" v-if="dueLaterTaslList.length === 0">Vous n'avez pas de tâche pour plus tard</span>
            <div v-else class="row">
                <task-component v-for="task in dueLaterTaslList" :key="task.id" :task="task"></task-component>
            </div></div>
        </div>

        <div class="row late">
            <div class="col">
                <div class="row">
                    <span>En retard</span></div>
            <span class="row" v-if="lateTaskList.length === 0">Vous n'avez pas de tâche en retard</span>
            <div v-else class="row">
                <task-component v-for="task in lateTaskList" :key="task.id" :task="task"></task-component>
            </div>
                </div>
        </div>

        <div class="row dueDate">
            <div class="col">
                <div class="row">
                    <span>Pas de date de fin</span></div>
            <span class="row" v-if="noDueDateTaskList.length === 0">Vous n'avez pas de tâche sans dueDate</span>
            <div v-else class="row">
                <task-component v-for="task in noDueDateTaskList" :key="task.id" :task="task"></task-component>
            </div></div>
        </div>


    </div>
</template>
<script>
import taskComponent from './Task.vue'
export default {
    name: 'TaskList',
    components: {
        taskComponent
    },
    props: {
        taskList: {
            type: Array,
            default: () => []
        }
    },
    data() {
        return {
            typeTimeConstant: {today:'today', thisWeek:'thisWeek', thisMonth:'thisMonth', noDueDate:'noDueDate', late:'late', dueLater:'dueLater'},
            todayTaskList: [],
            thisWeekTaskList: [],
            thisMonthTaskList: [],
            noDueDateTaskList: [],
            dueLaterTaslList: [],
            lateTaskList:[]
        }
    },
    computed: {

    },
    created() {
        console.log(this.taskList)
        this.fillAllSortedTaskList()
    },
    methods: {
        fillAllSortedTaskList() {
            this.taskList.forEach(task => {
                this.addTaskInList(task)
            })
        },
        addTaskInList(task) {
            if (!task.dueDate) {
                this.noDueDateTaskList.push(task)
            } else {
                let dueDate = new Date(task.dueDate)
                dueDate = new Date(dueDate.getFullYear(),dueDate.getMonth() , dueDate.getDate())
                let newDate = new Date()
                let todayDate = new Date(newDate.getFullYear(),newDate.getMonth() , newDate.getDate())
                let dateInOneWeek = newDate.setDate(newDate.getDate() + 7);
                let dateInOneMonth = newDate.setDate(newDate.getMonth() + 1);
                switch (true) {
                    case (dueDate < todayDate) :
                        this.lateTaskList.push(task)
                        break;
                    case (dueDate === todayDate) :
                        this.todayTaskList.push(task)
                        break;
                    case (dueDate < dateInOneWeek):
                        this.thisWeekTaskList.push(task)
                        break;
                    case (dueDate < dateInOneMonth) :
                        this.thisMonthTaskList.push(task)
                        break;
                    default:
                        this.dueLaterTaslList.push(task)
                }
            }

        }
    }
}

</script>
<style lang="scss" scoped>
.task-list-title {
    color: #252525;
    font-size: 20px;
    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
}

</style>
