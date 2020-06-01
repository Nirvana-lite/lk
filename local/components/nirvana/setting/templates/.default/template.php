<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
$this->setFrameMode(true);
global $USER;
if ($USER->GetID() == 131549) {
} ?>
<?php
if ($arResult['change']):
    ?>
    <div class="alert alert-success" role="alert">
        <h4 class="alert-heading">Уважаемый пользователь!</h4>
        <p>Ваши данные успешно сохранены</p>
        <hr>
        <p class="mb-0">После прохождения модерации они будут обновлены</p>
    </div>
<?php
endif;
?>
<div class="tabs">
    <div class="tab">
        <input type="radio" id="tab1" name="tab-group" checked>
        <label for="tab1" class="tab-title">Личные данные</label>
        <section class="tab-content">
            <? if ($arResult['isUrist']){ ?>
            <form id="personalInfo" onsubmit="saveAll()">
                <? }else{ ?>
                <form id="personalInfo" onsubmit="sendInfo(event,personalInfo,'personal')">
                    <? } ?>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="control-label">Аватар</div>
                                <img class="form-control-file img-thumbnail imgAvatar"
                                     src="<?= $arResult['user']['photo'] ?>">
                                <label class="changePhoto btn btn-primary">
                                    <small>Изменить фото</small>
                                    <input class="hidden" name="photo" type="file"/>
                                </label>
                                <? if (!$arResult['isUrist']): ?>
                                    <div class="btn btn-info" onclick="openAvas()">Выбрать аватар</div>
                                    <div id="openselectava" class="real-hint">
                                        <div class="top-hint">
                                            <div class="prm-cross"></div>
                                        </div>
                                        <span class="hint-caption"><strong>Выберите аватарку</strong></span><br/>
                                        <div class="editor_avatars">
                                            <? foreach ($arResult['my_avatars'] as $keyval => $imgavatar) { ?>
                                                <div class="avatar">
                                                    <input type="radio" class="niceavatar" value="<? echo $keyval; ?>"
                                                           name="AVATARNONUSER" id="myradio<?= $keyval ?>"
                                                           tabindex="-1"/>
                                                    <label for="myradio<?= $keyval ?>"
                                                           onclick="changeAvas('<?= $imgavatar ?>')">
                                                        <img class="lazy" src="<?= $imgavatar ?>">
                                                    </label>
                                                </div>
                                            <? } ?>
                                        </div>
                                    </div>
                                <? endif; ?>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="exampleFormControlInput2">Имя</label>
                                <input type="text" name="name" class="form-control" id="exampleFormControlInput2"
                                       placeholder="Иван" value="<?= $arResult['user']['name'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput3">Фамилия</label>
                                <input type="text" name="lastname" class="form-control" id="exampleFormControlInput3"
                                       placeholder="Иванов" value="<?= $arResult['user']['lastName'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput4">Отчетсво</label>
                                <input type="text" name="secondname" class="form-control" id="exampleFormControlInput4"
                                       placeholder="Иванович" value="<?= $arResult['user']['secondName'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput5">Город</label>

                                <select class="form-control" name="city">
                                    <? foreach ($arResult['user']['citys'] as $city): ?>
                                        <option <?= ($arResult['user']['selectCity'] === $city['id']) ? 'selected' : ''; ?>
                                                value="<?= $city['id'] ?>"><?= $city['name'] ?></option>
                                    <? endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="control-label" for="exampleFormControlInput5">Телефон</label>
                            <input type="text" name="phone" class="form-control" id="exampleFormControlInput5"
                                   placeholder="+7(495) 550-34-34" value="<?= $arResult['user']['phone'] ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label" for="exampleFormControlInput6">Почта для регистрации</label>
                            <input type="email" name="mail" class="form-control" id="exampleFormControlInput6"
                                   placeholder="mail@mail.ru" value="<?= $arResult['user']['mail'] ?>">
                            <? if ($arResult['isUrist']): ?>
                                <label class="control-label" for="exampleFormControlInput9">Рабочая почта (показывается
                                    на
                                    портале)</label>
                                <input type="email" name="workemail" class="form-control" id="exampleFormControlInput9"
                                       placeholder="mail@mail.ru" value="<?= $arResult['work']['workemail'] ?>">
                            <? endif; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="control-label" for="exampleFormControlInput7">Пароль</label>
                            <input type="password" name="pass" class="form-control" id="exampleFormControlInput7"
                                   placeholder="*******" value="">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label" for="exampleFormControlInput8">Повторение пароля</label>
                            <input type="password" name="confirmpass" class="form-control" id="exampleFormControlInput8"
                                   placeholder="*******" value="">
                        </div>
                    </div>
                    <div class="form-group col-md-4 col-md-offset-8">
                        <button type="submit" class="btn btn-success btn-lg btn-block">Сохранить</button>
                    </div>
                </form>
        </section>
    </div>
    <? if ($arResult['isUrist']): ?>
        <div class="tab">
            <input type="radio" id="tab2" name="tab-group">
            <label for="tab2" class="tab-title">Работа</label>
            <section class="tab-content">
                <? if ($arResult['isUrist']){ ?>
                <form id="workInfo" onsubmit="saveAll()">
                    <? }else{ ?>
                    <form method="post" id="workInfo" onsubmit="sendInfo(event,workInfo,'work')">
                        <? } ?>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="control-label" for="company">Компания</label>
                            <input type="text" name="company" class="form-control" id="company" placeholder=""
                                   value="<?= $arResult['work']['company'] ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label" for="department">Отдел</label>
                            <input type="text" name="department" class="form-control" id="department" placeholder=""
                                   value="<?= $arResult['work']['department'] ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="control-label" for="position">Статус</label>
                            <a href="/personal/changestatus/" class="btn btn-info form-control">Изменить</a>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label" for="address">Адрес</label>
                            <input type="text" name="address" class="form-control" id="address" placeholder=""
                                   value="<?= $arResult['work']['address'] ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="control-label" for="profile">Направление</label>
                            <input type="text" name="profile" class="form-control" id="profile" placeholder=""
                                   value="<?= $arResult['work']['profile'] ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label" for="workphone">Телефон</label>
                            <input type="text" name="workphone" class="form-control" id="workphone"
                                   placeholder="+7(550) 550-55-55" value="<?= $arResult['work']['workPhone'] ?>">
                        </div>
                    </div>
                    <div class="form-group col-md-4 col-md-offset-8">
                        <button type="submit" id="sendPersonal" class="btn btn-success btn-lg btn-block">Сохранить
                        </button>
                    </div>
                </form>
            </section>
        </div>
        <div class="tab">
            <input type="radio" id="tab3" name="tab-group">
            <label for="tab3" class="tab-title">Образование</label>
            <section class="tab-content">
                <? if ($arResult['isUrist']){ ?>
                <form id="educationInfo" onsubmit="saveAll()">
                    <? }else{ ?>
                    <form method="post" id="educationInfo" onsubmit="sendInfo(event,educationInfo,'education')">
                        <? } ?>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="control-label" for="vuz">Вуз</label>
                            <input type="text" name="vuz" class="form-control" id="vuz" placeholder=""
                                   value="<?= $arResult['educat']['vuz'] ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label" for="fak">Факультет</label>
                            <input type="text" name="fak" class="form-control" id="fak" placeholder=""
                                   value="<?= $arResult['educat']['fak'] ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="control-label" for="spec">Специальность</label>
                            <input type="text" name="spec" class="form-control" id="spec" placeholder=""
                                   value="<?= $arResult['educat']['spec'] ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label" for="year">Год выпуска</label>
                            <input type="text" name="year" class="form-control" id="year" placeholder=""
                                   value="<?= $arResult['educat']['year'] ?>">
                        </div>
                    </div>
                    <div class="form-group col-md-4 col-md-offset-8">
                        <button type="submit" class="btn btn-success btn-lg btn-block">Сохранить</button>
                    </div>
                </form>
            </section>
        </div>

        <div class="tab">
            <input type="radio" id="tab4" name="tab-group">
            <label for="tab4" class="tab-title">О себе</label>
            <section class="tab-content">
                <? if ($arResult['isUrist']){ ?>
                <form id="osebeInfo" onsubmit="saveAll()">
                    <? }else{ ?>
                    <form method="post" id="osebeInfo" onsubmit="sendInfo(event,osebeInfo,'osebe')">
                        <? } ?>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="control-label" for="doposebe">Дополнительная информация - О себе</label>
                                <textarea name="mytextar" id="doposebe" class="form-control" cols="30"
                                          rows="10"><?= $arResult['osebe']['mytextar'] ?></textarea>
                            </div>
                        </div>
                        <div class="form-group col-md-4 col-md-offset-8">
                            <button type="submit" class="btn btn-success btn-lg btn-block">Сохранить</button>
                        </div>
                    </form>
            </section>
        </div>
    <? endif; ?>
</div>
<script>
    function saveAll() {
        event.preventDefault();
        let arr = [
            {
                name1: personalInfo,
                name2: 'personal'
            },
            {
                name1: workInfo,
                name2: 'work'
            },
            {
                name1: educationInfo,
                name2: 'education'
            },
            {
                name1: osebeInfo,
                name2: 'osebe'

            },
        ];
        arr.forEach(function (item) {
            let formData = new FormData(item.name1);
            formData.append('form', item.name2);
            axios.post("<?=$this->__component->__path?>/saveInfo.php", formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then((response) => {
                    if (response.data.error) {
                        createAnsw(response.data.error);
                    } else {
                        createAnsw('done');
                    }

                })
                .catch((error) => {
                    createAnsw(error);
                });
        })
    }

    saveAll();

    function sendAvatar(avaKey) {
        event.preventDefault();
        event.stopPropagation();
        let formData = new FormData();
        formData.append('ava', avaKey);
        axios.post("<?=$this->__component->__path?>/saveAvatar.php", formData)
            .then((response) => {
                // console.log(response.data)
                // createAnsw('done');
            })
            .catch((error) => {
                //  createAnsw(error);
            });
    }

    function changeAvas(urls) {
        $('.imgAvatar').attr('src', urls);
        $('#openselectava').toggle();
        sendAvatar(urls);
    }

    function openAvas() {
        $('#openselectava').toggle();
    }

    function handleFileSelect(evt) {
        var file = evt.target.files; // FileList object
        var f = file[0];
        // Only process image files.
        if (!f.type.match('image.*')) {
            alert("Image only please....");
            return
        }
        var reader = new FileReader();
        // Closure to capture the file information.
        reader.onload = (function (theFile) {
            return function (e) {
                let imgurl = e.target.result;
                $('.imgAvatar').attr('src', imgurl)
            };
        })(f);
        // Read in the image file as a data URL.
        reader.readAsDataURL(f);
    }

    $("input[name=photo]").on("change", function () {
        handleFileSelect(event);
    });

    function sendInfo(evt, formId, formRes) {
        evt.preventDefault();
        let formData = new FormData(formId);
        formData.append('form', formRes);
        axios.post("<?=$this->__component->__path?>/saveInfo.php", formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
            .then((response) => {
                if (response.data.error) {
                    createAnsw(response.data.error);
                } else {
                    createAnsw('done');
                }

            })
            .catch((error) => {
                createAnsw(error);
            });
    }

    function createAnsw(answ) {

        let div = document.createElement('div');

        if (answ === 'done') {
            div.className = 'answer done';
            div.innerHTML = 'Ваши данные успешно сохранены. Отправлено на модерацию';
        } else {
            div.className = 'answer error';
            div.innerHTML = answ;
        }
        document.body.append(div);
        setTimeout(() => div.remove(), 2000);

    }
</script>




