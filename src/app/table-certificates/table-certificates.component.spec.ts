import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { TableCertificatesComponent } from './table-certificates.component';

describe('TableCertificatesComponent', () => {
  let component: TableCertificatesComponent;
  let fixture: ComponentFixture<TableCertificatesComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ TableCertificatesComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(TableCertificatesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
