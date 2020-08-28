import { User } from "~/models/User";

export const state = () => ({
  users: [],
  user: {},
  form: new User()
});
