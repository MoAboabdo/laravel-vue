<template>
  <!-- The component markup -->
  <div class="edit-product">
    <!-- The form for editing a product. The 'submit' event is prevented and instead the 'submitForm' method is called -->
    <form @submit.prevent="submitForm" class="edit-product-form">
      <!-- Various input fields bound to product properties with error handling -->
      <input
        class="input-field"
        v-model="product.name"
        placeholder="Product Name"
      />
      <p v-if="errors.name" class="error">{{ errors.name }}</p>

      <input
        class="input-field"
        v-model="product.description"
        placeholder="Product Description"
      />
      <p v-if="errors.description" class="error">{{ errors.description }}</p>

      <input
        class="input-field"
        v-model="product.price"
        placeholder="Product Price"
      />
      <p v-if="errors.price" class="error">{{ errors.price }}</p>

      <!-- Submit button -->
      <button type="submit" class="submit-button">Update Product</button>
    </form>
  </div>
</template>

<script>
import { ref, onMounted } from "vue"; // Importing necessary functionalities from Vue 3 Composition API
import { useRoute, useRouter } from "vue-router"; // Importing routing functionalities
import axios from "@/axios"; // Importing axios for making HTTP requests

export default {
  setup() {
    // Creating a reactive reference to the product object and error messages
    const product = ref({ id: null, name: "", description: "", price: "" });
    const errors = ref({});

    // Getting the current route instance and extracting product id from it
    const route = useRoute();
    product.value.id = route.params.id;

    // Getting the router instance
    const router = useRouter();

    // Defining input validation function
    const validateInput = () => {
      const errorMessages = {};
      if (!product.value.name) errorMessages.name = "Name is required";
      if (!product.value.description)
        errorMessages.description = "Description is required";
      if (!product.value.price || isNaN(product.value.price))
        errorMessages.price = "Price is required and must be a number";
      return errorMessages;
    };

    // Defining form submission function
    const submitForm = async () => {
      const errorMessages = validateInput();
      if (Object.keys(errorMessages).length > 0) {
        errors.value = errorMessages;
        return;
      }

      // Sending updated product data to the server
      try {
        await axios.put(`/products/${product.value.id}`, product.value);
        // Upon successful update, redirecting to the Product List page
        router.push("/");
      } catch (error) {
        console.error("An error occurred while updating the product:", error);
        if (error.response && error.response.status === 422) {
          // Handling server-side validation errors
          errors.value = error.response.data.errors;
        }
      }
    };

    // Fetching product data from the server when the component is mounted
    onMounted(async () => {
      try {
        const response = await axios.get(`/products/${product.value.id}`);
        product.value.name = response.data.name;
        product.value.description = response.data.description;
        product.value.price = response.data.price;
      } catch (error) {
        console.error("An error occurred while fetching the product:", error);
      }
    });

    // Exposing the reactive references and methods to be used within the template
    return { product, submitForm, errors };
  },
};
</script>

<style scoped>
.error {
  color: red;
}
.edit-product {
  max-width: 400px;
  margin: 20px auto;
  padding: 20px;
  background-color: #f9f9f9;
  border-radius: 8px;
}

.input-field {
  display: block;
  width: 100%;
  margin: 10px 0;
  padding: 10px;
  font-size: 1em;
}

.submit-button {
  padding: 10px 20px;
  background-color: #ff9800;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.submit-button:hover {
  background-color: #e68a00;
}
</style>
