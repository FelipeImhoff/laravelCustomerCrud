<script setup>
import { reactive, ref, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'

const form = reactive({
  name: '',
  email: '',
  phone: '',
  photo: ''
})

const router = useRouter()
const route = useRoute()

const editMode = ref(false)

onMounted(() => {
  if (route.name === 'customers.edit') {
    editMode.value = true
    getCustomer()
  }
})

const getCustomer = async () => {
  let response = await axios.get(`/api/customers/${route.params.id}`)
    .then((response) => {
      form.name = response.data.customer.name
      form.email = response.data.customer.email
      form.phone = response.data.customer.phone
      form.photo = response.data.customer.photo
    })
}

const handleSave = (values, actions) => {
  editMode.value ? updateCustomer(values, actions) : createCustomer(values, actions)
}

const createCustomer = (values, actions) => {
  axios.post('/api/customers', form)
    .then((response) => {
      router.push('/')
      toast.fire({
        icon: 'success',
        title: 'Cliente adicionado com sucesso!'
      })
    })
    .catch((error) => {
      toast.fire({
        icon: 'error',
        title: 'Erro ao criar cliente'
      })
    })
}

const updateCustomer = (values, actions) => {
  axios.put(`/api/customers/${route.params.id}`, form)
    .then((response) => {
      router.push('/')
      toast.fire({
        icon: 'success',
        title: 'Cliente alterado com sucesso!'
      })
    })
    .catch((error) => {
      toast.fire({
        icon: 'error',
        title: 'Erro ao alterar cliente'
      })
    })
}

const getImage = () => {
  let image = '/upload/no-image.png'
  if (form.photo)
    return form.photo.indexOf('base64') != -1 ? form.photo : '/upload/' + form.photo

  return image
}

const handleFileChange = (e) => {
  let file = e.target.files[0]
  let reader = new FileReader()
  reader.onloadend = () => {
    form.photo = reader.result
  }

  reader.readAsDataURL(file)
}

const handlePhone = (event) => {
  let input = event.target
  form.phone = phoneMask(input.value)
}

const phoneMask = (value) => {
  if (!value) return ''
  value = value.replace(/\D/g, '')
  value = value.replace(/(\d{2})(\d)/, '($1) $2')
  value = value.replace(/(\d)(\d{4})$/, '$1-$2')
  return value
}
</script>
<template>
  <div class='form'>
    <div class='title'>
      <h1>
        <span v-if='!editMode'>Adicionar</span>
        <span v-else>Editar</span>
        cliente
      </h1>
    </div>

    <div class='content'>
      <div class='fields'>
        <div class='form-field'>
          <input type='text' placeholder='Nome' class='input' v-model='form.name'>
          <label for='name' class='label'>Nome</label>
        </div>
        <div class='form-field'>
          <input type='email' placeholder='E-mail' class='input' v-model='form.email'>
          <label for='email' class='label'>E-mail</label>
        </div>
        <div class='form-field'>
          <input @keyup='handlePhone' maxlength='15' type='tel' placeholder='Telefone' class='input'
            v-model='form.phone'>
          <label for='phone' class='label'>Telefone</label>
        </div>
      </div>
      <div class='image-field'>
        <div>
          <img :src='getImage()' />
        </div>
        <div>
          <input type='file' @change='handleFileChange'>
        </div>
      </div>
    </div>
    <div class='footer'>
      <button @click='handleSave' class='btn'>{{ editMode ? 'Salvar' : 'Criar' }}</button>
    </div>

  </div>
</template>