<template>
    <form @submit.prevent="submitNewData()">
        <input type="text"  class="form-control" v-model="add_name">
    </form>
</template>
<script>

export default {
  name: "addNew",
  props : {
      addNew: {
          default : false,
          type : [Boolean]
      },
      dataObject:{
          default : {},
          type : [Array, Object]
      },
      url:{
          default : '',
          type : String
      },
      dataModel:{
          default : '',
          type : String
      }
  },
  data() {
    return {
      add_name : '',
    };
  },
  methods: {
    submitNewData() {
        const _this = this;
        let name = _this.add_name;
        let URL = baseUrl +'/'+ `${this.url}?name=` + name;
        this.axios.post(URL).then((response) => {
            let value = response.data.result;
            _this.dataObject.push(value);
            _this.$set(_this.formObject,this.dataModel, value.id);
            _this.add_name = '';
            _this.$emit('click');
        });
      },
  },
};
</script>
<style scoped>
.form-control {
  display: inline;
}
</style>


