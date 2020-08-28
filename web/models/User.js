import { mapUTCDate, dateFormat } from "../utils/Util";
import { DemographicProfile } from "./DemographicProfile";
import { UserRoles } from "~/utils/UserRoles";

export class User {
  constructor({
    avatar = null,
    role = UserRoles.Student,
    password = null,
    password_confirmation = null,
    username = null,
    first_name = null,
    last_name = null,
    middle_name = null,
    email = null,
    is_active = true,
    demographic_profile = new DemographicProfile()
  } = {}) {
    this.avatar = avatar;
    this.role = role;
    this.password = password;
    this.password_confirmation = password_confirmation;
    this.username = username;
    this.first_name = first_name;
    this.last_name = last_name;
    this.middle_name = middle_name;
    this.email = email;
    this.password = password;
    this.is_active = is_active;
    this.demographic_profile = demographic_profile;
  }
}

export const createUser = data => {
  return Object.freeze(new User(data));
};

export const mapUser = obj => ({
  id: obj.id,
  name: obj.name,
  email: obj.email,
  role: obj.role,
  authorized: obj.authorized,
  created_at: dateFormat(mapUTCDate(obj.created_at))
});
