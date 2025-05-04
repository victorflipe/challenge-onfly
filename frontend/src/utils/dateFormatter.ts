import { format } from "date-fns"

export const formatDate = (dateString: string) => {

    const dateFormat = dateString.split('T')
    const dateFormatReplace = dateFormat[0].replaceAll('-', '/')
    const date = new Date(dateFormatReplace)
    return format(date, "MM/dd/yyyy")
}

export const onlyDate = (date: Date): Date => {
    const d = new Date(date)
    d.setHours(0, 0, 0, 0)
    return d
  }