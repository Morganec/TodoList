<template>
    <div class="modal" tabindex="-1" role="dialog" id="createTaskModal" ref="createTaskModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Créer une nouvelle tâche</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form ref="myForm" >
                        <div class="row">
                            <div class="col-6 form-group">
                                <label for="taskName">Nom : </label>
                                <input  v-model="task.name" class="form-control" id="taskName" placeholder="Entrer un nom" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6 form-group">
                                <label>Date d'échéance : </label>
                                <v-date-picker id="datePicker" v-model='task.dueDate' />
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer ">
                    <div class=" spanRequiredField" v-if="buttonIsDisable">
                        Le champs "nom" ne peux être vide
                    </div>
                    <div class=" " >
                    <button data-dismiss="modal" type="button" class="task-button task-cancel">
                        <i class="fas fa-times mr-1"></i> Annuler
                    </button>
                    <button @click="addTask()" type="button" class="task-button task-save" :class="{'disabled':buttonIsDisable}"  :disabled="buttonIsDisable">
                        <i class="fas fa-check mr-1"></i> Enregistrer
                    </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { bus } from '../app';
export default {
    name: 'CreateTaskModal',
    components: {

    },
    props: {
    },
    data() {
        return {
            task: {
                isDone: false,
                name: null,
                dueDate: null
            },
            isNameEmpty: false
        }
    },
    computed: {
        buttonIsDisable: function () {
            if(!this.task.name) {
                return true
            }else {
                return false
            }
        }
    },
    created() {
    },
    methods: {
        addTask() {
                axios.post('/task/', this.task)
                    .then(resp => {
                        bus.$emit('taskAdded', this.task)
                        $('#createTaskModal').modal('hide')
                    })
                    .catch(error => {
                        console.log(error);
                    })
            }
    }
}

</script>
<style lang="scss" scoped>
.task-button {
    padding: 6px;
    color: white;
    border: solid 1px transparent;
    border-radius: 10px;
    margin: 5px;
}
.task-cancel {
    background-color: #a0a0a0;
    &:hover, &:active {
        background-color: #808080;
    }
}
.task-save:enabled {
    background-color: #87b452;
    &:hover:enabled, &:active:enabled {
        background-color: #6c9041;
    }

}

.spanRequiredField {
    color: #dc4c42;
    font-size: 14px;
}
</style>
