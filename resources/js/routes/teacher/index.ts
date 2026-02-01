import sections from './sections'
import grades from './grades'
import domains from './domains'
import competencies from './competencies'
import practice from './practice'
import attendance from './attendance'
import portfolio from './portfolio'
const teacher = {
    sections: Object.assign(sections, sections),
grades: Object.assign(grades, grades),
domains: Object.assign(domains, domains),
competencies: Object.assign(competencies, competencies),
practice: Object.assign(practice, practice),
attendance: Object.assign(attendance, attendance),
portfolio: Object.assign(portfolio, portfolio),
}

export default teacher