<template>
    <div class="col">
        <div class="row task-container align-items-center" v-if="!isEdited" @click="(e) => openEditTask(e)">
            <div class="col align-self-center">
                <div class="row my-auto align-items-center">
                    <div class="col align-self-center">
                        <input v-model="copyTask.isDone" type="checkbox" class="checkBox" :id="'isDoneCheckPrinted' + copyTask.id"> <label :for="'isDoneCheckPrinted' + copyTask.id" class="ml-2 labelCheckPrinted">{{copyTask.name}}</label>
                    </div>
                </div>

            </div>
            <div class="col d-flex justify-content-end">
                <div class="row">
                    <button  @click="(e) =>openEditTask(e)" type="button" class="task-button task-edit">
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
                                <label for="taskName" class="labelInputName">Nom : </label>
                                <input  v-model="copyTask.name" class="form-control" id="taskName" placeholder="Enter name">
                            </div>
                            <div class="col form-group">
                                <label>Date d'échéance : </label>
                                <v-date-picker id="datePicker" v-model='copyTask.dueDate' />
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

import {bus} from "../app";

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
                    if(this.copyTask.dueDate !== this.task.dueDate) {
                        bus.$emit('taskDateUpdated', this.task, this.copyTask)
                    }
                    this.isEdited= false
                })
                .catch(error => {
                    console.log(error);
                })
        },
        openEditTask(event) {
            if (!(event.target.classList.contains('checkBox')) && !(event.target.classList.contains('labelCheckPrinted')) && !(event.target.classList.contains('task-delete')) ) {
                this.isEdited= true
            }
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
    font-size: 16px;
    background-color: white;
    transition: padding 0.4s ease;
    &:hover {
        background-color: #f9f9f9;
        cursor: pointer;
    }
    .labelCheckPrinted{
        margin-bottom: 0;
    }
    .task-button {
        padding: 4px 10px;
        color: white;
        font-size: 14px;
        border: solid 1px transparent;
        border-radius: 5px;
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
    .labelInputName {
        margin-bottom: 0;
        margin-top: 0.5rem;
    }

}

</style>
