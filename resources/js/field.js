import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('detail-editor', DetailField)
  app.component('form-editor', FormField)
})
