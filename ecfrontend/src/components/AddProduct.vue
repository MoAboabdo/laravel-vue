<template>
  <!-- Form for adding a product -->
  <!-- @submit.prevent="submitForm" prevents the default form submission and calls the 'submitForm' method instead -->
  <form @submit.prevent="submitForm" class="add-product-form">
    <!-- Input for the product name -->
    <!-- v-model="name" binds the input to the 'name' data property -->
    <input class="input-field" v-model="name" placeholder="Product Name" />
    <!-- Error message for the product name -->
    <!-- Displayed if 'errors.name' is truthy -->
    <p v-if="errors.name" class="error">{{ errors.name }}</p>

    <!-- Input for the product description -->
    <!-- v-model="description" binds the input to the 'description' data property -->
    <input
      class="input-field"
      v-model="description"
      placeholder="Product Description"
    />
    <!-- Error message for the product description -->
    <!-- Displayed if 'errors.description' is truthy -->
    <p v-if="errors.description" class="error">{{ errors.description }}</p>

    <!-- Input for the product price -->
    <!-- v-model="price" binds the input to the 'price' data property -->
    <input class="input-field" v-model="price" placeholder="Product Price" />
    <!-- Error message for the product price -->
    <!-- Displayed if 'errors.price' is truthy -->
    <p v-if="errors.price" class="error">{{ errors.price }}</p>

    <!-- Button for submitting the form -->
    <button type="submit" class="submit-button">Add Product</button>
  </form>
</template>

<script>
// Importing the axios instance
import axios from "@/axios";

export default {
  // Component data
  data() {
    return {
      // Product details
      name: "",
      description: "",
      price: "",
      // Validation errors
      errors: {},
    };
  },
  methods: {
    // Validate the input fields
    validateInput() {
      // Errors object
      const errors = {};
      // Validate the product name
      if (!this.name) errors.name = "Name is required";
      // Validate the product description
      if (!this.description) errors.description = "Description is required";
      // Validate the product price
      if (!this.price || isNaN(this.price))
        errors.price = "Price is required and must be a number";
      return errors;
    },
    // Handle form submission
    async submitForm() {
      // Validate the input fields
      const errors = this.validateInput();
      // If there are validation errors, update the 'errors' data property and stop execution
      if (Object.keys(errors).length > 0) {
        this.errors = errors;
        return;
      }

      try {
        // Send a POST request to the API to add the product
        await axios.post("/products", {
          name: this.name,
          description: this.description,
          price: this.price,
        });
        // If the request is successful, redirect to the product list
        this.$router.push("/");
      } catch (error) {
        // If an error occurs, log it to the console
        console.error("An error occurred while adding the product:", error);
      }
    },
  },
};
</script>

<style scoped>
.error {
  color: red;
}
.add-product-form {
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
  background-color: #4caf50;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.submit-button:hover {
  background-color: #45a049;
}
</style>
