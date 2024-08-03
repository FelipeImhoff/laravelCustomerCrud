<script setup>
import { useRouter } from 'vue-router'
import { ref, onMounted } from 'vue'

const router = useRouter()

const customers = ref([])
const pages = ref([])

onMounted(async () => {
  getCustomers()
})

const newCustomer = () => {
  router.push('/customers/create')
}

const editCustomer = (customerId) => {
  router.push(`/customers/${customerId}/edit`)
}

const deleteCustomer = (customerId) => {

  // Criando modal
  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: "btn btn-success",
      cancelButton: "btn btn-danger"
    },
    buttonsStyling: true
  })

  // Chamando modal
  swalWithBootstrapButtons.fire({
    title: "Tem certeza que deseja excluir o cliente?",
    text: "Você não conseguira reverter isso!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Sim, delete!",
    cancelButtonText: "Não, cancele!",
    reverseButtons: true
  }).then((result) => {
    // Resultado: realmente era pra excluir?
    // Se sim
    if (result.isConfirmed) {
      //tenta deletar cliente
      axios.delete(`/api/customers/${customerId}`)
        //sucesso ao excluir
        .then((response) => {
          swalWithBootstrapButtons.fire({
            title: "Deletado!",
            text: "Cliente excluído com sucesso!",
            icon: "success"
          })
          getCustomers()
          //erro ao excluir
        }).catch((error) => {
          toast.fire({
            icon: 'error',
            title: 'Erro ao excluir cliente'
          })
        })
      //não queria relamente excluir o cliente
    } else {
      swalWithBootstrapButtons.fire({
        title: "Cancelado",
        text: "O cliente NÃO foi excluído",
        icon: "error"
      })
    }
  })
}

const customerPhoto = (photo) => {
  return '/upload/' + photo
}

const getCustomers = async () => {
  let response = await axios.get('/api/customers')
    .then((response) => {
      customers.value = response.data.customers.data
      pages.value = response.data.customers.links
      pages.value.pop()
      pages.value.shift()
    })
}

const changePage = (page) => {
  if (!page.url || page.active) {
    return
  }

  axios.get(page.url)
    .then((response) => {
      customers.value = response.data.customers.data
      pages.value = response.data.customers.links
      pages.value.pop()
      pages.value.shift()
    })
}
</script>
<template>
  <div class='index'>
    <div class='page-header'>
      <div class='page-title'>
        <h1>Clientes</h1>
      </div>
      <div class='add-customer'>
        <button @click='newCustomer' class='btn'>
          Adicionar novo cliente
        </button>
      </div>
    </div>
    <div class='table'>
      <div class='table-header'>
        <p class='table-col1'>Foto</p>
        <p class='table-col2'>Nome</p>
        <p class='table-col3'>Email</p>
        <p class='table-col4'>Telefone</p>
        <p class='table-col5'>Ações</p>
      </div>
      <div v-for='customer in customers' :key='customer.id' class='table-line'>
        <div class='table-col1'>
          <img :src='customerPhoto(customer.photo)' style='height: 40px;background-color: white;'>
        </div>
        <p class='table-col2'>
          {{ customer.name }}
        </p>
        <div class='table-col3'>
          <p>{{ customer.email }}</p>
        </div>
        <div class='table-col4'>
          <p>{{ customer.phone }}</p>
        </div>
        <div class='table-col5'>
          <div class='action'>
            <button @click='editCustomer(customer.id)'>
              <i class='fas fa-pencil-alt'></i>
            </button>
          </div>
          <div class='action'>
            <button @click='deleteCustomer(customer.id)'>
              <i class='far fa-trash-alt'></i>
            </button>
          </div>
        </div>
      </div>
      <div class='table-pages'>
        <div class='pages'>
          <button v-for='page in pages' :key='page.label' v-html='page.label' @click='changePage(page)'
            :class="page.active ? ' btn-selected' : 'btn'">
          </button>
        </div>
      </div>
    </div>
  </div>
</template>