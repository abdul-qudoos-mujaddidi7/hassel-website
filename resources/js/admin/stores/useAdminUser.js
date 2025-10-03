import { onMounted, ref } from 'vue';
import axios from 'axios';

const user = ref(null);
const loading = ref(false);
const error = ref(null);
let isLoaded = false;

export default function useAdminUser() {
  const setUser = (data) => {
    user.value = data;
  };

  const fetchUser = async () => {
    if (isLoaded || loading.value) {
      return;
    }

    loading.value = true;
    error.value = null;

    try {
      const response = await axios.get('/admin/me');
      user.value = response.data;
      isLoaded = true;
    } catch (err) {
      error.value = err;
      user.value = null;
    } finally {
      loading.value = false;
    }
  };

  onMounted(fetchUser);

  return {
    user,
    loading,
    error,
    setUser,
    fetchUser,
  };
}

