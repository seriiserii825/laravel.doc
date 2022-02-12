// ProductController
<?php
    public function index(Request $request)
    {
        $sort_field = $request->get('sort_field');
        $sort_direction = $request->get('sort_direction');
        return ProductResource::collection(Product::query()->orderBy($sort_field, $sort_direction)->get());
    }
?>

//  TableSortTable
<template>
  <div>
    <a href="#" @click.prevent="sort_table(table_column)">{{ title }}</a>
    <span v-if="sort_field === table_column && sort_direction === 'asc'"
      >&uarr;</span
    >
    <span v-if="sort_field === table_column && sort_direction === 'desc'"
      >&darr;</span
    >
  </div>
</template>
<script>
export default {
  props: {
    title: String,
    table_column: String,
    sort_field: String,
    sort_direction: String,
  },
  methods: {
    sort_table() {
      this.$emit("sort_table", this.table_column);
    },
  },
};
</script>

Index.vue
<template>
<th>
  <table-sort-header
    title="Title"
    table_column="title"
    @sort_table="sort_table"
    :sort_field="sort_field"
    :sort_direction="sort_direction"
  ></table-sort-header>
</th>
</template>
<script>
import TableSortHeader from "../../components/Admin/TableSortHeader.vue";
export default {
  data() {
    return {
      items: [],
      sort_field: "created_at",
      sort_direction: "desc",
    };
  },
  components: {
    TableSortHeader,
  },
  methods: {
    sort_table(field) {
      if (this.sort_field === field) {
        this.sort_direction = this.sort_direction === "asc" ? "desc" : "asc";
      } else {
        this.sort_field = field;
        this.sort_direction = "asc";
      }
      this.getItems();
    },
    getItems() {
      axios
        .get(
          "/api/auth/products/" +
            "?sort_field=" +
            this.sort_field +
            "&sort_direction=" +
            this.sort_direction +
            "&api_token=" +
            this.$store.getters.getToken
        )
        .then((res) => {
          this.items = res.data.data;
          // this.items.forEach((elem) => console.log(elem, "elem"));
        })
        .catch((error) => {
          console.log(error, "error");
        });
    },
  },
  created() {
    this.getItems();
  },
};
</script>

