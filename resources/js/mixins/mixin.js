export default {
    data() {
        return {
            formData: {},
            SelectFilter: {},
            filter: {},
            per_page: 20,
            keyword: "",
            imageData: [],
            baseUrl: baseUrl,
            selectInputs: {},
        }
    },
    methods: {

        modalOpen() {
            let _this = this;
            _this.$emit("resetForm");
            _this.openModal(_this.modalId, _this.modalHeader);
        },

        onFileSelected: function(event, fieldIndex) {
            let file = event.target.files[0];
            let reader = new FileReader();
            reader.onload = (e) => {
                this.imageData[fieldIndex] = e.target.result;
            };
            reader.readAsDataURL(file);

        },

        getGeneralData: function($array, callback = false) {
            const _this = this;
            _this.axios.post(_this.urlGenerate('general'), $array).then(response => {

                _this.$store.commit('requiredData', response.data.result)
                if (typeof callback == 'function') {
                    callback(true);
                }
            }).catch(function(error) {
                _this.$toastr('error', 'Whoops..!! something went wrong', 'Error');
            });
        },

        getDataList: function(page = 1) {
            const _this = this;
            var data_params = Object.assign(this.filter, _this.$store.state.filter, { page: page });
            this.$store.commit('httpRequest', true);
            _this.axios({ method: "get", url: _this.urlGenerate(), params: data_params })
                .then(function(response) {
                    var retData = response.data;
                    _this.$store.commit('httpRequest', false);
                    if (parseInt(retData.status) === 2000) {
                        _this.$store.commit('dataList', retData.result)

                    } else if (retData.status === 3001) {
                        let current_module = _this.Config.current_module ? _this.Config.current_module : ''
                        _this.getConfigurations(current_module)
                        _this.$toastr('warning', retData.message, 'Warning');
                    } else {
                        _this.$store.state.DataList = [];
                        _this.$toastr(retData.type, retData.message, 'Warning');
                    }
                }).catch(function(error) {
                    var retData = error.response.data;
                    _this.$toastr('error', retData.message, 'Error');
                });
        },

        onFileSelect(event, name) {
            const _this = this;
            var formData = new FormData();
            var imagefile = event.target.files[0];
            formData.append("image", imagefile);
            _this.axios.post(_this.urlGenerate('image-upload'), formData).then(response => {
                if (parseInt(response.data.status) === 2000) {
                    var retData = response.data.result;
                    _this.$set(_this.formObject, name, retData);
                    _this.$set(_this.formObject, 'logo', retData);
                } else {
                    _this.$toastr('error', response.data.message, 'Error');
                }
            }).catch(function(error) {
                _this.$toastr('error', 'Something wrong', 'Error');
            });
        },

        submitForm: function(formData = false, model = true, callback = false) {

            const _this = this;
            var URL, method;
            if (_this.formType === 2) {
                URL = `${_this.urlGenerate()}/${_this.updateId}`;
                method = 'put';
            } else {
                URL = _this.urlGenerate();
                method = 'post';
            }

            this.$validator.validate().then(valid => {
                if (valid) {
                    this.$validator.errors.clear();
                    _this.$store.commit('httpRequest', true);
                    var Data = formData ? formData : _this.formObject;
                    var form_data = Object.assign(Data, this.imageData);
                    _this.axios({ method: method, url: URL, data: form_data }).then(function(response) {
                        var retData = response.data;
                        _this.$store.commit('httpRequest', false);
                        if (parseInt(retData.status) === 2000) {
                            if (model) {
                                _this.$store.state.currentFromModel = 1;
                                _this.closeModal(model);
                                _this.getDataList();
                                _this.resetForm(formData);
                            }
                            if (typeof callback == 'function') {
                                callback(retData.result);
                            }
                            _this.resetForm(formData);
                            _this.$toastr('success', retData.message, 'Success');
                        }
                        if (parseInt(retData.status) === 3000) {
                            _this.$toastr('warning', retData.message, 'Warning');
                            _this.assignValidationError(retData.result);
                        }
                        if (parseInt(retData.status) === 3001) {
                            let current_module = _this.Config.current_module ? _this.Config.current_module : ''
                            _this.getConfigurations(current_module)
                            _this.$toastr('warning', retData.message, 'Warning');
                        }
                        if (parseInt(retData.status) === 5000) {
                            _this.$toastr('error', retData.message, 'Error');
                        }
                    }).catch(function(error) {
                        _this.$store.commit('httpRequest', false);
                        if (error.response.status == 422) {
                            var retData = error.response.data;
                            _this.$toastr('warning', retData.message, 'Warning');
                            _this.assignValidationError(retData.errors);
                        } else if (error.response.status == 403) {
                            var retData = error.response.data;
                            _this.$toastr('warning', retData.message, 'Warning');
                        } else {
                            _this.$toastr('error', 'Something Wrong', 'Error');

                        }
                    });
                }
            });
        },

        editData: function(data, updateId, modalTitle = '', modalName = 'formModal', callback = false) {
            const _this = this;

            _this.$store.commit('formObject', Object.assign({}, data));
            _this.$store.commit('updateId', updateId);
            _this.$store.commit('formType', 2);
            _this.openModal(modalName, modalTitle);

            if (typeof callback == 'function') {
                callback(data);
            }

        },
        showNewForm: function(type) {
            const _this = this;
            if (_this.selectInputs[type] === undefined) {
                _this.$set(_this.selectInputs, type, true)
            } else {
                _this.selectInputs[type] = !_this.selectInputs[type];
            }
        },

        deleteInformation: function(index, ID, url = false, callback = false, callDataList = true) {
            const _this = this;
            this.$swal({
                title: 'Are you sure..??',
                text: 'Data will be delete Permanently??',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '<i class="fa fa-check">Yes</i>',
                cancelButtonText: '<i class="fa fa-close">Cancel</i>',
                showCloseButton: true,
            }).then((result) => {
                if (result.value) {
                    var URL = !url ? `${_this.urlGenerate()}/${ID}` : url;
                    _this.axios.delete(URL)
                        .then(function(response) {
                            var retData = response.data;
                            _this.$store.commit('httpRequest', false);
                            if (parseInt(retData.status) === 2000) {
                                _this.$toastr('success', retData.message, 'Success');
                                if (callDataList) {
                                    _this.getDataList();
                                }
                                if (typeof callback == 'function') {
                                    callback(true);
                                }
                            } else {
                                _this.$toastr('warning', retData.message, 'Warning');
                            }
                        }).catch(function(error) {
                            _this.$toastr('error', 'Something Wrong', 'Error');
                        });
                }
            });
        },

        getConfigurations: function(module, callback = false) {
            const _this = this;
            this.$store.commit('httpRequest', true);
            _this.axios({ method: "get", url: _this.urlGenerate('api/configurations?module=' + module) })
                .then(function(response) {
                    _this.$store.commit('httpRequest', false);
                    if (parseInt(response.data.status) === 2000) {
                        _this.$store.commit('Config', response.data.result);
                        // _this.assignCurrentAccess();
                        if (typeof callback == 'function') {
                            callback(true);
                        }
                    }
                }).catch(function(error) {
                    /*var retData = error.response.data;
                    _this.$toastr('error', retData.message, 'Error');*/
                });
        },

        assignCurrentAccess: function() {
            const _this = this;
            var path = this.$route.path;
            var currentPage = {};
            $.each(_this.Config.menus, function(index, each) {
                if (path == each.link) {
                    currentPage = each;
                } else {
                    $.each(each.submenus, function(index, eachSub) {
                        if (path == eachSub.link) {
                            currentPage = eachSub;
                        }
                    });
                }
            });
            _this.$store.commit('currentPage', currentPage);

        },

        can: function(permission) {
            return true;
            let permissionName = permission.toLowerCase();
            let permissions = this.Config.permissions ? this.Config.permissions : [];
            if (permissions.includes(permissionName)) {
                return true;
            }
            return false;
        },

        showData(dataArray, fieldName) {
            if ((dataArray !== null && dataArray !== undefined) &&
                (dataArray[fieldName] !== undefined && dataArray[fieldName] !== null)) {
                return dataArray[fieldName];
            } else {
                return '-';
            }
        },

        getConfig: function(Obj, name) {
            if ((Obj !== undefined && Obj !== null !== null) &&
                (Obj[name] !== undefined && Obj[name] !== null)) {
                return Obj[name];
            } else {
                return name;
            }
        },

        openModal: function(modalName = 'formModal', title = false) {
            if (title) {
                this.$store.commit('modalTitle', title);
            }
            $('#' + modalName).modal('show');
            this.$validator.reset();
            this.removeErrorMessage();
        },

        closeModal: function(modalName = 'createModal', resetForm = true, resetFormType = true) {
            const _this = this;
            this.$validator.reset();
            this.removeErrorMessage();
            $('#' + modalName).modal('hide');
            this.$store.commit('formType', 1);
            if (resetForm) {
                this.$store.commit('formObject', {});
            }
            if (resetFormType) {
                _this.$store.state.formType = 1;
            }
        },

        getUrl: function() {
            if (this.$route.meta.dataUrl !== undefined) {
                return this.$route.meta.dataUrl;
            }
            return '';
        },

        urlGenerate: function(customUrl = false) {
            var url = '';
            if (customUrl) {
                url = `${this.baseUrl}/${customUrl}`;
            } else {
                url = `${this.baseUrl}/${this.getUrl()}`;
            }
            return url;
        },

        assignValidationError: function(errors) {
            const _this = this;
            $.each(errors, function(index, errorValue) {
                _this.$validator.errors.add({
                    id: index,
                    field: index,
                    name: index,
                    msg: errorValue[0],
                });
            })
        },

        resetForm: function(formData) {
            if (typeof formData == 'object') {
                Object.keys(formData).forEach(function(key) {
                    formData[key] = '';
                });
                return formData;
            }
        },

        pageTitle: function() {
            return this.$route.meta.pageTitle;
        },

        resetFilter: function(parameter = []) {
            this.$store.commit('resetFilter', parameter);
            this.getDataList();
        },

        clickImageInput: function(ID) {
            $('#' + ID).click();
        },

        getImage: function(imagePath) {
            if (imagePath !== undefined && imagePath !== '') {
                return `${this.baseUrl}/${imagePath}`;
            }
        },

        indexToLabel: function(string) {
            var removed_space = '';
            if (typeof string === 'string') {
                removed_space = string.replace(/_/g, ' ');
                if (typeof removed_space !== 'string') {
                    return index;
                }
                return removed_space.charAt(0).toUpperCase() + removed_space.slice(1)
            }
            return '';
        },

        addRow: function(object, pushEr) {
            if (typeof object === 'object') {
                console.log('ee');
                object.push(pushEr);
            }
        },

        deleteRow: function(object, index) {
            object.splice(index, 1);
        },

        removeErrorMessage: function() {
            var span = $('.error_message');
            var s = $('.is-invalid').removeClass('is-invalid');
            var s1 = $('.select2-selection').removeClass('is-invalid');
            $('.vs--searchable .vs__dropdown-toggle').removeAttr('style');
            $(this).addClass('is-valid');
            span.remove();
        },

        serialData: function(index) {
            return this.dataList.from > 1 ?
                this.dataList.from + index :
                index + 1
        },

        formatTaka(num) {
            return num ? '৳ ' + new Intl.NumberFormat().format(num) : '৳ ' + 0
        },

    },
    watch: {
        'errors': {
            handler: function(value) {
                var is_invalid = $('.is-invalid');
                $(is_invalid).removeAttr("title", '');
                $(is_invalid).removeClass('is-invalid');
                $(is_invalid).removeClass('is-invalid');
                $('.vs--searchable .vs__dropdown-toggle').removeAttr('style');
                $('.error_message').remove();
                if (value.items.length > 0) {
                    value.items.forEach(function(val) {
                        var target = $("[name='" + val.field + "']");
                        var targetParent = $(target).parent();
                        console.log(targetParent);

                        var select2Target = $(targetParent).find('span.select2-selection');
                        var select2Target1 = $(targetParent).find('.vs--searchable .vs__dropdown-toggle');
                        var message = val.msg;
                        if ($('.is-invalid').length == 0) {
                            $(targetParent).remove(`#${val.field}_message`);
                        }
                        if ($(`#${val.field}_message`).length == 0) {
                            $(targetParent).append(`<span style="color:red" class="error_message" id="${val.field}_message">${message.replace(val.field, "")}</span>`);
                            $(select2Target1).attr("style", "border:1px solid red");
                        }

                        $(target).addClass('is-invalid');
                        $(select2Target).addClass('is-invalid');
                        // $(select2Target1).addClass('is-invalid');

                        $(target).attr("title", message.replace(val.field, ""));
                    });
                }
            },
            deep: true
        },

        '$store.getters.httpRequest': function() {
            if (this.httpRequest) {
                $('button').attr('disabled', 'disabled');
                $('input').attr('disabled', 'disabled');
            } else {
                $('button').removeAttr('disabled');
                $('input').removeAttr('disabled');
            }
        },
    },
    computed: {
        formType: function() {
            return this.$store.getters.formType;
        },

        formObject: function() {
            return this.$store.getters.formObject;
        },

        dataList: function() {
            return this.$store.getters.dataList;
        },

        updateId: function() {
            return this.$store.getters.updateId;
        },

        httpRequest: function() {
            return this.$store.getters.httpRequest;
        },

        requiredData: function() {
            return this.$store.getters.requiredData;
        },

        modalTitle: function() {
            return this.$store.getters.modalTitle;
        },

        Config: function() {
            return this.$store.getters.Config;
        },

        currentPage: function() {
            return this.$store.getters.currentPage;
        },

    },
}