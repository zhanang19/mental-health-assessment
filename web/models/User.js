import { mapUTCDate, dateFormat } from '../utils/Util'

export class User {
  constructor({ 
    avatar = null,
    role = null, 
    password = null,
    password_confirmation = null,
    daycare_id = null,
    username = null,
    first_name = null,
    last_name = null,
    middle_name = null,
    email = null,
    time_zone = null,
    is_active = null,
  } = {}) {
    this.avatar = avatar 
    this.role = role 
    this.password = password 
    this.password_confirmation = password_confirmation 
    this.daycare_id = daycare_id 
    this.username = username 
    this.first_name = first_name 
    this.last_name = last_name 
    this.middle_name = middle_name 
    this.email = email 
    this.time_zone = time_zone 
    this.password = password 
    this.is_active = is_active 
  }
}

export const createUser = (data) => {
  return Object.freeze(new User(data))
}

export const mapUser = (obj) => ({
  id: obj.id,
  name: obj.name,
  email: obj.email,
  role: obj.role,
  authorized: obj.authorized,
  created_at: dateFormat(mapUTCDate(obj.created_at)),
})