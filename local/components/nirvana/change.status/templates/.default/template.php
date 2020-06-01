<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
$this->setFrameMode(true);
?>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

<div class="container register" id="myTabContent">
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Данные сохранены</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="inf"><i class="fa fa-5x fa-check-square-o" aria-hidden="true"></i></p>
                    <p>В течении <b>3 дней</b> данные пройдут модерацию.</p>
                    <p>Ваш статус будет изменен на <b>{{works.position.value}}</b></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 register-right">
            <div class="d-flex justify-content-end">
                <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                           aria-controls="home" data-elem="urist" aria-selected="true">Юрист</a>
                    </li>
                    <li class="nav-item" >
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                           aria-controls="profile" data-elem="advocat" aria-selected="false">Адвокат</a>
                    </li>
                </ul>
            </div>

            <div class="tab-content" id="changeTabs">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <h3 class="register-heading">Стать Юристом</h3>
                        <form class="row register-form" id="urist"  ref="urist" @submit.prevent.stop="sendInfo('urist')">
                        <div class="col-md-6">
                            <div class="form-group">
                                <h4>Работа</h4>
                            </div>
                                <div class="form-group" v-for="(work, key) in works">
                                    <template v-if="key == 'position'">
                                        <select class="form-control" v-model="work.value">
                                                <option v-for="(select, key) in selectedPosition">{{select}}</option>
                                        </select>
                                    </template>
                                    <template v-else>
                                        <input type="text" class="form-control" v-model="work.value" :placeholder="work.name" required/>
                                    </template>
                                </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <h4>Образование</h4>
                            </div>
                            <div class="form-group" v-for="(educat, key) in educations">
                                    <input type="text" class="form-control" v-model="educat.value"
                                           :placeholder="educat.name" required/>
                            </div>
                            <input type="submit" class="btnRegister" value="Отправить"/>
                        </div>
                        </form>
                </div>
                <div class="tab-pane fade show" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <h3 class="register-heading">Стать Адвокатом</h3>
                    <form class="row register-form" id="advocat" ref="advocat" @submit.prevent.stop="sendInfo('advocat')">
                        <div class="col-md-6">
                            <div class="form-group">
                                <h4>Работа</h4>
                            </div>
                            <div class="form-group" v-for="(work, key) in works">
                                <template v-if="key == 'position'">
                                    <input type="text" class="form-control" v-model="advocat" readonly/>
                                </template>
                                <template v-else>
                                    <input type="text" class="form-control" v-model="work.value" :placeholder="work.name" required/>
                                </template>
                            </div>
                            <div class="form-group">
                                <h4>Данные удостоверения</h4>
                            </div>
                            <div class="form-group" v-for="(another,key) in anotherInput">
                                <template v-if="key == 'certificate_photo'">
                                    <label for="certificate_photo">{{another.name}}</label>
                                    <input type="file" ref="file" class="form-control-file" @change="handleFileUpload()" required>
                                </template>
                                <template v-else>
                                    <input type="text" class="form-control" v-model="another.value" :placeholder="another.name" required/>
                                </template>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <h4>Образование</h4>
                            </div>
                            <div class="form-group" v-for="(educat, key) in educations">
                                <input type="text" class="form-control" v-model="educat.value"
                                       :placeholder="educat.name" required />
                            </div>
                            <input type="submit" class="btnRegister" value="Отправить"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#myTab a').on('shown.bs.tab', function (event) {
            tabsContent.works.position.value = (event.target.dataset.elem === 'advocat') ? 'Адвокат' : 'Юрист'
        });
    });
  var tabsContent = new Vue({
        el: '#myTabContent',
        data: function () {
            return {
                works:<?=json_encode($arResult['info']['work'])?>,
                educations:<?=json_encode($arResult['info']['education'])?>,
                selectedPosition: <?=json_encode($arResult['selectPosition'])?>,
                anotherInput: <?=json_encode($arResult['anotherInput'])?>,
                advocat: 'Адвокат'
            }
        },
        methods:{
            handleFileUpload: function(){
              this.anotherInput.certificate_photo.value = this.$refs.file[0].files[0];
            },
            changeModal: function(){
                $('#exampleModalCenter').modal('show')
            },
            sendInfo: function (formId) {
                if (this.$refs[formId].checkValidity()){
                    let str = new FormData();
                    for (let i in this.works){
                        str.append(`work[${this.works[i].bdName}]`,this.works[i].value)
                    }
                    for (let i in this.educations){
                        str.append(`educations[${this.educations[i].bdName}]`,this.educations[i].value)
                    }
                    for (let i in this.anotherInput){
                            str.append(`anotherInput[${this.anotherInput[i].bdName}]`,this.anotherInput[i].value)
                    }
                    axios.post("<?=$componentPath?>/changeInfo.php", str,{
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                        .then((response) => {
                            console.log(response.data)
                            if (response.data.done){
                                this.changeModal()
                            }
                        })
                        .catch((error) => {
                            console.log(error);
                        });
                }
                  /*  */
                // }
            }
        }
    })
</script>

