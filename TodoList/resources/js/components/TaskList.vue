<template>
    <div class="container">
        <div class="row align-items-center title"><span class="task-list-title">Mes tâches</span>
            <button @click="showModal()" type="button" class="task-button-create">
                <i class="fas fa-check mr-1"></i> Add
            </button>
        </div>
        <div class="row todayTask" v-if="!(thisWeekTaskList.length === 0)">
            <div class="col-12">
                <div class="row"><span>Aujourd'hui</span></div>
                <span class="row" v-if="thisWeekTaskList.length === 0">Vous n'avez pas de tâche pour aujourd'Hui</span>
                <div v-else class="row" v-for="task in todayTaskList" :key="task.id">
                    <task-component  :task="task"></task-component><br/>
                </div>
            </div>
        </div>

        <div class="row thisWeekTask"  v-if="!thisWeekTaskList.length === 0">
            <div class="col">
                <div class="row">
                    <span>Cette semaine</span></div>
            <span class="row" v-if="thisWeekTaskList.length === 0">Vous n'avez pas de tâche pour cette semaine</span>
            <div v-else class="row" v-for="task in thisWeekTaskList" :key="task.id">
                <task-component  :task="task"></task-component><br/>
            </div></div>
        </div>

        <div class="row thisMonth" v-if="!(thisMonthTaskList.length === 0)">
            <div class="col">
                <div class="row">
                    <span>Ce mois</span></div>
            <span class="row" v-if="thisMonthTaskList.length === 0">Vous n'avez pas de tâche pour ce mois</span>
            <div v-else class="row" v-for="task in thisMonthTaskList" :key="task.id" >
                <task-component :task="task"></task-component><br/>
            </div></div>
        </div>

        <div class="row dueLater" v-if="!(dueLaterTaslList.length === 0)">
            <div class="col">
                <div class="row">
                    <span>Plus tard</span></div>
            <span class="row" v-if="dueLaterTaslList.length === 0">Vous n'avez pas de tâche pour plus tard</span>
            <div v-else class="row" v-for="task in dueLaterTaslList" :key="task.id" >
                <task-component :task="task"></task-component><br/>
            </div></div>
        </div>

        <div class="row late" v-if="!(lateTaskList.length === 0)">
            <div class="col">
                <div class="row">
                    <span>En retard</span></div>
            <span class="row" v-if="lateTaskList.length === 0">Vous n'avez pas de tâche en retard</span>
            <div v-else class="row" v-for="task in lateTaskList" :key="task.id" >
                <task-component :task="task"></task-component>
            </div>
                </div>
        </div>

        <div class="row dueDate"  v-if="!(noDueDateTaskList.length === 0)">
            <div class="col">
                <div class="row">
                    <span>Pas de date de fin</span></div>
            <span class="row" v-if="noDueDateTaskList.length === 0">Vous n'avez pas de tâche sans dueDate</span>
            <div  class="row"  v-for="task in noDueDateTaskList" :key="task.id">
                <task-component :task="task"></task-component><br/>
            </div></div>
        </div>

        <create-task-modal v-if="isModalShowing" ></create-task-modal>
    </div>
</template>
<script>
import taskComponent from './Task.vue'
import CreateTaskModal from './CreateTaskModal'
import {bus} from "../app";
export default {
    name: 'TaskList',
    components: {
        taskComponent,
        CreateTaskModal
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
            lateTaskList:[],
            isModalShowing: false
        }
    },
    computed: {

    },
    beforeDestroy() {
        bus.$off('taskAdded', this.addTaskInList)
    },
    created() {
        console.log(this.taskList)
        this.fillAllSortedTaskList()
        bus.$on('taskAdded', this.addTaskInList)
    },
    methods: {
        fillAllSortedTaskList() {
            this.taskList.forEach(task => {
                this.addTaskInList(task)
            })
        },
        showModal() {
            this.isModalShowing = true
            this.$nextTick(()=> {
                $('#createTaskModal').modal('show');
            })
        },
        addTaskInList(task) {
            if (this.isModalShowing) {
                this.isModalShowing = false
            }
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
.container {
    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
}
.task-list-title {
    color: #252525;
    font-size: 20px;
    font-weight: bold;
    .col {
        witdth: 100%;
    }
}
.task-button-create {
    color: white;
    border: solid 1px transparent;
    border-radius: 10px;
    margin: 5px;
    background-color: #87b452;
    &:hover, &:active {
        background-color: #6c9041;
    }
}

</style>
