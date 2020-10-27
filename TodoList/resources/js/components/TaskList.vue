<template>
    <div class="container">
        <span class="task-list-title">Mes tâches</span>
        <div v-for="task in taskList" :key="task.id">
            <task-component  :task="task"></task-component>
            <span>{{getDueDateType(task)}}</span>
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
            typeTimeConstant: {today:'today', thisWeek:'thisWeek', thisMonth:'thisMonth', noDueDate:'noDueDate', late:'late', later:'later'}
        }
    },
    computed: {

    },
    created() {
        console.log(this.taskList)
    },
    methods: {
        getDueDateType(task) {
            if (!task.dueDate) {
                return this.typeTimeConstant.noDueDate
            }
            let dueDate = new Date(task.dueDate)
            dueDate = new Date(dueDate.getFullYear(),dueDate.getMonth() , dueDate.getDate())
            let newDate = new Date()
            let todayDate = new Date(newDate.getFullYear(),newDate.getMonth() , newDate.getDate())
            let dateInOneWeek = newDate.setDate(newDate.getDate() + 7);
            let dateInOneMonth = newDate.setDate(newDate.getMonth() + 1);
            switch (true) {
                case (dueDate < todayDate) :
                    return this.typeTimeConstant.late
                case (dueDate === todayDate) :
                    return this.typeTimeConstant.today
                    break;
                case (dueDate < dateInOneWeek):
                    return this.typeTimeConstant.today
                    break;
                case (dueDate < dateInOneMonth) :
                    return this.typeTimeConstant.thisMonth
                    break;
                default:
                    return this.typeTimeConstant.later
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
