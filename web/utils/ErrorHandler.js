import { isObjectEmpty } from "./Util";

/**
 * Handle HTTP errors via status codes.
 *
 * @param { Object } error
 * @returns { String }
 */
export const handleError = error => {
  const defaultErrorMessage = "Oops! Something went wrong.";

  let errorMessage = error?.response?.data?.message;

  if (!!errorMessage) {
    switch (error.response.status) {
      case 401:
        errorMessage = "You are not authenticated.";
        // $nuxt.$router.push({ name: "index" });
        break;
      case 403:
        errorMessage = "You are not authorized.";
        break;
      case 422:
        errorMessage = "The data provided is not valid.";
        break;
      case 500:
        errorMessage =
          "Sorry, something is broken in the system. Try again later.";
      default:
        errorMessage = defaultErrorMessage;
        break;
    }
  }

  if (isObjectEmpty(error)) {
    return defaultErrorMessage;
  }

  return errorMessage;
};
