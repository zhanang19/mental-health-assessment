export default function({ store, redirect }) {
  if (!store.getters.isStudent) {
    return redirect({ name: "app-dashboard" });
  }
}
