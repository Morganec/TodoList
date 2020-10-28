<template>
    <div class="col">
        <div class="row task-container align-items-center" v-if="!isEdited">
            <div class="col align-self-center">
                <div class="row my-auto align-items-center">
                    <div class="col align-self-center">
                        <input v-model="copyTask.isDone" type="checkbox" class="checkBox" :id="'isDoneCheckPrinted' + copyTask.id"> <label :for="'isDoneCheckPrinted' + copyTask.id" class="ml-2">{{copyTask.name}}</label>
                    </div>
                </div>

            </div>
            <div class="col d-flex justify-content-end">
                <div class="row">
                    <button  @click="openEditTask(copyTask.id)" type="button" class="task-button task-edit">
                        <i class="fas fa-pen mr-1"></i> Modifier
                    </button>
                    <button  @click="deleteTask(copyTask.id)" type="button" class="task-button task-delete">
                        <i class="fas fa-trash mr-1"></i>Supprimer
                    </button>
                </div>
            </div>
        </div>
        <div class="row task-container align-items-center" v-if="isEdited">
                <div class="col align-self-center">
                    <form>
                        <div class="row align-items-center">
                            <div class="col form-check">
                                <input v-model="copyTask.isDone" type="checkbox" class="checkBox" :id="'isDoneCheck' + copyTask.id"> <label :for="'isDoneCheck' + copyTask.id" class="ml-2">C'est terminé ! </label>
                            </div>
                            <div class="col form-group">
                                <label for="taskName">Name</label>
                                <input  v-model="copyTask.name" class="form-control" id="taskName" placeholder="Enter name">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col d-flex justify-content-end">
                    <button   @click="cancelEditTask()" type="button" class="task-button task-cancel">
                        <i class="fas fa-times mr-1"></i> Annuler
                    </button>
                    <button @click="updateTask()" type="button" class="task-button task-save">
                        <i class="fas fa-check mr-1"></i> Enregistrer
                    </button>
                </div>
        </div>
    </div>
</template>
<script>

export default {
    name: 'Task',
    components: {
    },
    props: {
        task: {
            type: Object,
            default: ''
        }
    },
    data() {
        return {
            isEdited: false,
            copyTask: _.cloneDeep(this.task)
        }
    },
    watch: {
        'copyTask.isDone' : function(){
            console.log('test')
            this.$nextTick(() => {
                if (!this.isEdited) {
                    this.updateTask()
                }
            })
        }
    },
    computed: {

    },
    created() {
    },
    methods: {
        deleteTask(id) {
            //Due to the way Axios sends POST, PUT and DELETE requests. I need to actually POST the request and include method delete to avoid error 405 (not allowed).
            axios.post('/task/'+id, {
                _method: 'DELETE'
            })
                .then(resp => {
                    console.log(resp)
                    location.reload();
                })
                .catch(error => {
                    console.log(error);
                })
        },
        updateTask() {
            let taskObject = {
                name: this.copyTask.name,
                dueDate: this.copyTask.dueDate,
                isDone: this.copyTask.isDone
            }
            console.log('taskObject',taskObject)
            axios.put('/task/'+this.copyTask.id,
               taskObject
                )
                .then(resp => {
                    console.log(resp)
                    this.isEdited= false
                })
                .catch(error => {
                    console.log(error);
                })
        },
        openEditTask(id) {
            this.isEdited= true
        },
        cancelEditTask() {
            this.copyTask = this.task
            this.isEdited = false
        }
    }
}

</script>
<style lang="scss" scoped>
.task-container {
    border: solid 0.2px #a0a0a0;
    border-radius: 5px ;
    margin: 5px;
    font-size: 18px;
    .task-button {
        padding: 6px;
        color: white;
        border: solid 1px transparent;
        border-radius: 10px;
        margin: 5px;
    }
    .task-edit {
        background-color: #00a9be;
        &:hover, &:active {
            background-color: #008798;
        }
    }
    .task-delete {
        background-color: #dc4c42;
        &:hover, &:active {
            background-color: #b03c34;
        }
    }
    .task-cancel {
        background-color: #a0a0a0;
        &:hover, &:active {
            background-color: #808080;
        }
    }
    .task-save {
        background-color: #87b452;
        &:hover, &:active {
            background-color: #6c9041;
        }
    }

    input[type=checkbox] {
        position: relative;
        cursor: pointer;
    }
    input[type=checkbox]:before {
        content: "";
        display: block;
        position: absolute;
        width: 20px;
        height: 20px;
        top: -3px;
        left: 0;
        border: 1px solid #a0a0a0;
        border-radius: 2px;
        background-color: white;
    }
    input[type=checkbox]:checked:before{
        width: 20px;
        height: 20px;
        background-color: #87b452;
        border: 2px solid #87b452;
    }
    input[type=checkbox]:checked:after {
        content: "\2713";
        display: block;
        color: white;
        font-size: 25px;
        position: absolute;
        top: -10px;
        left: 1px
    }

}

</style>
