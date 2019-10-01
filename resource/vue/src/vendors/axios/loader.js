

/**
 *
 * API
 *
 */

// Vue
import axios from 'axios'

// Export
export default axios.create ({
  baseURL: process.env.VUE_APP_API_BASE_URL,
  headers: {
    'Content-Type': 'application/json',
    'Authorization': ''
  }
});
