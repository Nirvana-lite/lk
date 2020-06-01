<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
$this->setFrameMode(true);
?>
<div  id="advList">
    <div class="card-columns">
        <div class="card" v-for="(item,key) in items">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                <span v-if="item.new" class="fa-stack fa-lg">
                    <i class="fa fa-square-o fa-stack-2x"></i>
                    <i class="fa fa-fire fa-stack-1x"></i>
                </span>
                    <div>
                        <button class="btn btn-sm" @click="changeView(key)"  data-toggle="tooltip" data-placement="top" title="Подробнее">
                            <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                        </button>
                        <button class="btn btn-sm" v-if="!item.isActive" @click="changeActive(key)" data-toggle="tooltip" data-placement="top" title="Активация">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        </button>
                        <button class="btn btn-sm" @click="ascDel(key)" data-toggle="tooltip" data-placement="top" title="Удалить">
                            <i class="fa fa-window-close-o" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
                <hr>
                <h5 class="card-title">
                    {{item.name}}
                </h5>

                <template v-if="item.view">
                    <p class="card-text">{{item.text}}</p>
                </template>
                <template v-else>
                    <p class="card-text">{{item.preview}}</p>
                </template>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <small>{{item.mail}}</small>
                <small :class="[item.isActive?'green':'red']">
                    <i class="fa fa-circle" aria-hidden="true"></i>
                </small>
            </div>
        </div>
    </div>
<!--modal-->
    <div class="modal fade" id="delModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Удаление</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Вы точно хотите удалить?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" @click="delItem()">ДА</button>
                    <button type="button" class="btn btn-secondary">Нет</button>
                </div>
            </div>
        </div>
    </div>
<!--    modal end-->
</div>
<script>
   var advList = new Vue({
        el: '#advList',
        data: function () {
            return {
                items:<?=json_encode($arResult['items'], true)?>,
                choiseKey:0
            }
        },
        methods: {
            changeView: function (itemKey) {
                this.items[itemKey].view = !this.items[itemKey].view
            },
            ascDel: function(itemKey){
                this.choiseKey = itemKey;
                $('#delModal').modal('show');
            },
            delItem: function(){
                let str = new FormData();
                str.append('info[id]', this.items[this.choiseKey].id);
                str.append('info[change]', 'del');
                axios.post("<?=$componentPath?>/changeInfo.php", str)
                    .then((response) => {
                        if (response.data){
                            advList.items.splice(this.itemKey,1);
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            changeActive: function (itemKey) {
                let str = new FormData();
                str.append('info[id]', this.items[itemKey].id);
                str.append('info[change]', 'active');
                axios.post("<?=$componentPath?>/changeInfo.php", str)
                    .then((response) => {
                        if (response.data){
                            this.items[itemKey].isActive = true;
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
        }
    })
</script>
